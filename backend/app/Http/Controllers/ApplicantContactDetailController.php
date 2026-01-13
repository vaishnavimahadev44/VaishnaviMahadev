<?php

namespace App\Http\Controllers;

use App\Models\ApplicantContactDetail;
use Illuminate\Http\Request;

class ApplicantContactDetailController extends Controller
{
    // List all contact details for an application
    public function index($applicationId)
    {
        $contacts = ApplicantContactDetail::where('application_id', $applicationId)->get();
        return response()->json($contacts, 200);
    }

    // Store new contact detail
    public function store(Request $request, $applicationId)
    {
        $validated = $request->validate([
            'full_name'             => 'required|string|max:150',
            'email'                 => 'required|email|max:150',
            'contact_number'        => 'required|string|max:50',
            'preferred_contact_time'=> 'required|string|max:50',
            'additional_notes'      => 'nullable|string|max:65535',
        ]);

        $validated['application_id'] = $applicationId;

        $contact = ApplicantContactDetail::create($validated);

        return response()->json($contact, 201);
    }

    // Show a specific contact detail
    public function show($applicationId, $id)
    {
        $contact = ApplicantContactDetail::where('application_id', $applicationId)
                                         ->findOrFail($id);
        return response()->json($contact, 200);
    }

    // Update a contact detail
    public function update(Request $request, $applicationId, $id)
    {
        $validated = $request->validate([
            'full_name'             => 'sometimes|string|max:150',
            'email'                 => 'sometimes|email|max:150',
            'contact_number'        => 'sometimes|string|max:50',
            'preferred_contact_time'=> 'sometimes|string|max:50',
            'additional_notes'      => 'nullable|string|max:65535',
        ]);

        $contact = ApplicantContactDetail::where('application_id', $applicationId)
                                         ->findOrFail($id);

        $contact->update($validated);

        return response()->json($contact, 200);
    }

    // Delete a contact detail
    public function destroy($applicationId, $id)
    {
        $contact = ApplicantContactDetail::where('application_id', $applicationId)
                                         ->findOrFail($id);
        $contact->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}