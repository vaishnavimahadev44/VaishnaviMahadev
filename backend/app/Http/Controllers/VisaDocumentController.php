<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaDocument;
use Illuminate\Http\Request;

class VisaDocumentController extends Controller
{
    // List all the visa documents for a given application
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->documents, 200);
    }

    // Add a visa document details
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

            $validated = $request->validate([
                'applicant_type' => 'required|in:PRIMARY,ADDITIONAL',
                'applicant_id'   => 'required|integer',
                'document_type'  => 'required|in:Passport,Visa,Birth Certificate,Marriage Certificate,Bank Statement,Employment Letter,Other',
                'notes'          => 'nullable|string',
            ]);

        $document = $application->documents()->create($validated);

        return response()->json($document, 201);
    }

    // Show one visa document detail based on applicationId and documentId
    public function show($applicationId, $documentId)
    {
        $document = VisaDocument::where('application_id', $applicationId)
                                       ->where('document_id', $documentId)
                                       ->firstOrFail();
        return response()->json($document, 200);
    }

    // Update all or some fields in visa document detail
    public function update(Request $request, $applicationId, $documentId)
    {
        $document = VisaDocument::where('application_id', $applicationId)
                                   ->where('document_id', $documentId)
                                   ->firstOrFail();
        if (!$document) {
        return response()->json(['message' => 'Visa document details not found'], 404);
        }

        if ($request->isMethod('put')) {
                // Full update: require all fields                       
                $validated = $request->validate([
                    'applicant_type' => 'required|in:PRIMARY,ADDITIONAL',
                    'applicant_id'   => 'required|integer',
                    'document_type'  => 'required|in:Passport,Visa,Birth Certificate,Marriage Certificate,Bank Statement,Employment Letter,Other',
                    'notes'          => 'nullable|string',
                ]);
        } else {
                // PATCH: partial update, only validate provided fields
                $validated = $request->validate([
                    'applicant_type' => 'sometimes|in:PRIMARY,ADDITIONAL',
                    'applicant_id'   => 'sometimes|integer',
                    'document_type'  => 'sometimes|in:Passport,Visa,Birth Certificate,Marriage Certificate,Bank Statement,Employment Letter,Other',
                    'notes'          => 'sometimes|nullable|string',
                ]);
        }   

        $document->update($validated);

        return response()->json($document, 200);
    }

    // Delete visa package details
    public function destroy($applicationId, $documentId)
    {
        $document = VisaDocument::where('application_id', $applicationId)
                                  ->where('document_id', $documentId)
                                  ->firstOrFail();
        $document->delete();

        return response()->json(['message' => 'Visa document details deleted successfully'], 200);
    }
}