<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeDocument;

class EmployeeDocumentController extends Controller
{
    public function index()
    {
        $employeeDocuments = EmployeeDocument::with('user')->latest()->get();
        $users = \App\Models\User::where('role', '!=', 'admin')->get();
        return view('admin.employee_documents', compact('employeeDocuments', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'document_type' => 'required|string',
            'employee_document_file' => 'required|file|max:51200', // 50MB
        ]);

        $file = $request->file('employee_document_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('employee_documents', $fileName, 'public');

        EmployeeDocument::create([
            'user_id' => $request->user_id,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'verified_status' => 'Pending'
        ]);

        return redirect()->back()->with('success', 'Employee document uploaded successfully!');
    }

    public function verify($id)
    {
        $doc = EmployeeDocument::findOrFail($id);
        $doc->update(['verified_status' => 'Verified']);
        return response()->json(['success' => true]);
    }
    
    public function reject($id)
    {
        $doc = EmployeeDocument::findOrFail($id);
        $doc->update(['verified_status' => 'Rejected']);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $doc = EmployeeDocument::findOrFail($id);
        if ($doc->file_path && \Storage::disk('public')->exists($doc->file_path)) {
            \Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();
        return response()->json(['success' => true]);
    }

    public function preview($id)
    {
        $doc = EmployeeDocument::findOrFail($id);
        $path = storage_path('app/public/' . $doc->file_path);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    }
}
