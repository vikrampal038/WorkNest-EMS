<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        // Get all documents that don't have a parent (i.e. are the latest versions or roots)
        $documents = Document::with(['user', 'versions', 'signatures'])->whereNull('parent_document_id')->latest()->get();
        $users = \App\Models\User::where('role', '!=', 'admin')->get(); // Fetch employees
        
        $totalStorage = "4.2 GB"; // Mocked for now, can calculate later
        $totalFiles = $documents->count();
        $pendingSigns = $documents->where('status', 'Pending Signature')->count();
        $expiringSoon = $documents->where('status', 'Expiring Soon')->count();
        // Employee KYC Documents
        $employeeDocuments = \App\Models\EmployeeDocument::with('user')->latest()->get();

        return view('admin.documents', compact('documents', 'employeeDocuments', 'users', 'totalStorage', 'totalFiles', 'pendingSigns', 'expiringSoon'));
    }

    public function store(Request $request)
    {
        \Log::info('Document Upload Request:', $request->all());
        \Log::info('Files:', $request->allFiles());
        try {
            $file = $request->file('document_file');
            if ($file && !$file->isValid()) {
                \Log::error('Upload Error Code: ' . $file->getError());
                \Log::error('Upload Error Message: ' . $file->getErrorMessage());
            }

            $request->validate([
                'document_file' => 'required|file|max:51200', // 50MB max
                'category' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ' . json_encode($e->errors()));
            throw $e;
        }

        try {
            $file = $request->file('document_file');
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('documents', time() . '_' . $fileName, 'public');

            $requiresSignature = $request->has('requires_signature') && $request->requires_signature == '1';
            $visibility = $request->input('visibility', 'all');
            
            // Handle versioning
            $parent_id = null;
            $version = 1;
            if ($request->has('parent_document_id') && $request->parent_document_id != '') {
                $parent = Document::find($request->parent_document_id);
                if ($parent) {
                    $parent_id = $parent->id;
                    $version = $parent->versions()->count() + 2; // +1 for the parent itself, +1 for this new one
                    // Also we might want to update the parent status to archived or just rely on the query to show only latest
                }
            }

            Document::create([
                'user_id' => $request->user_id ?: \App\Models\User::where('role', '!=', 'admin')->first()->id, // fallback if empty
                'name' => $fileName,
                'category' => $request->category,
                'file_path' => $path,
                'size' => number_format($file->getSize() / 1048576, 2) . ' MB',
                'status' => $requiresSignature ? 'Pending Signature' : 'Active',
                'requires_signature' => $requiresSignature,
                'visibility' => $visibility,
                'version' => $version,
                'parent_document_id' => $parent_id,
            ]);

            return redirect()->back()->with('success', 'Document uploaded successfully!');
        } catch (\Exception $e) {
            \Log::error("Document upload failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['upload_error' => $e->getMessage()]);
        }
    }

    public function sign(Request $request, $id)
    {
        $doc = Document::findOrFail($id);
        
        \App\Models\DocumentSignature::create([
            'document_id' => $doc->id,
            'user_id' => $request->user() ? $request->user()->id : (\App\Models\User::where('role', '!=', 'admin')->first()->id ?? 1), // fallback if not authenticated
            'signed_at' => now(),
            'ip_address' => $request->ip(),
        ]);

        $doc->update(['status' => 'Active']);
        return response()->json(['success' => true]);
    }

    public function renew($id)
    {
        $doc = Document::findOrFail($id);
        $doc->update([
            'status' => 'Active',
            'expiry_date' => now()->addYear()->format('Y-m-d')
        ]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $doc = Document::findOrFail($id);
        if ($doc->file_path && \Storage::disk('public')->exists($doc->file_path)) {
            \Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();
        return response()->json(['success' => true]);
    }

    public function preview($id)
    {
        $doc = Document::findOrFail($id);
        $path = storage_path('app/public/' . $doc->file_path);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        $docs = Document::whereIn('id', $ids)->get();
        foreach ($docs as $doc) {
            if ($doc->file_path && \Storage::disk('public')->exists($doc->file_path)) {
                \Storage::disk('public')->delete($doc->file_path);
            }
            $doc->delete();
        }
        return response()->json(['success' => true]);
    }

    public function bulkDownload(Request $request)
    {
        $ids = $request->input('ids', []);
        $docs = Document::whereIn('id', $ids)->get();
        
        if ($docs->isEmpty()) {
            return redirect()->back()->withErrors(['download' => 'No files selected']);
        }

        $zip = new \ZipArchive;
        $zipFileName = 'documents_'.time().'.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            foreach ($docs as $doc) {
                $filePath = storage_path('app/public/' . $doc->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $doc->name);
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
