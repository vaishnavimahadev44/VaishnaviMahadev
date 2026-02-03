<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadedDocument;

class CustomerUploadDocumentController extends Controller
{
    // CREATE (upload file)
    public function store(Request $request, $customerId)
    {
        $validated = $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|max:5120', // validate each file
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $documentFile = UploadedDocument::create([
                'customer_id' => $customerId,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getMimeType(),
                'file_data' => file_get_contents($file->getRealPath()),
            ]);

            $uploadedFiles[] = $documentFile;
        }

        return response()->json([
            'message' => 'Files uploaded successfully',
            'files' => $uploadedFiles
        ], 201);


    }

    // READ (download file)
    public function download($customerId, $documentId)
    {
        $file = UploadedDocument::where('customer_id', $customerId)
            ->findOrFail($documentId);

        return response($file->file_data)
            ->header('Content-Type', $file->file_type)
            ->header('Content-Disposition', 'attachment; filename="' . $file->file_name . '"');
    }

    // UPDATE (replace file)
    public function update(Request $request, $customerId, $documentId)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:5120',
        ]);

        $file = $request->file('file');
        $documentFile = UploadedDocument::where('customer_id', $customerId)
            ->findOrFail($documentId);

        $documentFile->update([
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_data' => file_get_contents($file->getRealPath()),
        ]);

        return response()->json($documentFile, 200);
    }

    // DELETE
    public function destroy($customerId, $fileId)
    {
        $file = UploadedDocument::where('customer_id', $customerId)
            ->findOrFail($fileId);
        $file->delete();

        return response()->json(['message' => 'File deleted successfully'], 200);
    }
}