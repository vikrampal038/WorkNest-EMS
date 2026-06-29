<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Document;
use App\Models\User;

class DocumentController extends Controller
{
    public function index()
    {
        // For testing, grab the seeded employee user
        $user = User::where('email', 'employee@worknest.com')->first();
        $user_id = $user ? $user->id : 1;
        
        $documents = Document::where('user_id', $user_id)->get();

        return view('employee.documents', compact('documents'));
    }

    public function showSign($id)
    {
        $document = Document::findOrFail($id);
        return view('employee.sign', compact('document'));
    }

    public function submitSign(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        
        $signatureBase64 = $request->input('signature');
        $signaturePath = null;
        
        if (preg_match('/^data:image\/(\w+);base64,/', $signatureBase64, $type)) {
            $signatureBase64 = substr($signatureBase64, strpos($signatureBase64, ',') + 1);
            $type = strtolower($type[1]);

            if (in_array($type, ['jpg', 'jpeg', 'png'])) {
                $signatureBase64 = str_replace(' ', '+', $signatureBase64);
                $signatureData = base64_decode($signatureBase64);
                
                $fileName = 'signatures/' . time() . '_' . uniqid() . '.' . $type;
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $signatureData);
                $signaturePath = $fileName;
            }
        }
        
        $document->update([
            'status' => 'Signed',
            'signature_path' => $signaturePath
        ]);

        return redirect()->route('employee.documents')->with('success', 'Document signed successfully!');
    }
}
