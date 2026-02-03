<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisaDocumentFile;

class VisaDocumentFileController extends Controller
{
    // CREATE (upload file)
    public function store(Request $request, $documentId)
    {
        $validated = $request->validate([
            'files'   => 'required|array',
            'files.*' => 'required|file|max:5120', // validate each file
        ]);
    
        $uploadedFiles = [];
    
        foreach ($request->file('files') as $file) {
            $documentFile = VisaDocumentFile::create([
                'document_id' => $documentId,
                //'file_id'   => $file->file_id(),
                'file_name'   => $file->getClientOriginalName(),
                'file_type'   => $file->getMimeType(),
                'file_data'   => file_get_contents($file->getRealPath()),
                //'uploaded_at' => $file->uploaded_at->useCurrent(),
            ]);
    
            $uploadedFiles[] = $documentFile;
        }
    
        return response()->json([
            'message' => 'Files uploaded successfully',
            'files'   => $uploadedFiles
        ], 201);
    
    
    }

    // READ (download file)
    public function download($fileId)
    {
        $file = VisaDocumentFile::findOrFail($fileId);

        return response($file->file_data)
            ->header('Content-Type', $file->file_type)
            ->header('Content-Disposition', 'attachment; filename="' . $file->file_name . '"');
    }

    // UPDATE (replace file)
    public function update(Request $request, $fileId)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:5120',
        ]);

        $file = $request->file('file');
        $documentFile = VisaDocumentFile::findOrFail($fileId);

        $documentFile->update([
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_data' => file_get_contents($file->getRealPath()),
        ]);

        return response()->json($documentFile, 200);
    }

    // DELETE
    public function destroy($fileId)
    {
        $file = VisaDocumentFile::findOrFail($fileId);
        $file->delete();

        return response()->json(['message' => 'File deleted successfully'], 200);
    }
}