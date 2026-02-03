<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\AdditionalApplicant;
use Illuminate\Http\Request;

class AdditionalApplicantController extends Controller
{
    // List all additional applicants for a given application
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->additionalApplicants, 200);
    }

    // store an additional applicant
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|string|max:150',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'relationship' => 'required|string|max:50'
        ]);

        $additionalApplicant = $application->additionalApplicants()->create($validated);

        return response()->json($additionalApplicant, 201);
    }

    // Show one additional applicant based on ID
    public function show($applicationId, $id)
    {
        $additionalApplicant = AdditionalApplicant::where('application_id', $applicationId)
            ->where('additional_applicant_id', $id)
            ->firstOrFail();
        return response()->json($additionalApplicant, 200);
    }

    // Update additional applicant
    public function update(Request $request, $applicationId, $id)
    {
        $additionalApplicant = AdditionalApplicant::where('application_id', $applicationId)
            ->where('additional_applicant_id', $id)
            ->firstOrFail();

        if (!$additionalApplicant) {
            return response()->json(['message' => 'Additional applicant details not found'], 404);
        }

        if ($request->isMethod('put')) {
            // Full update: require all fields                       
            $validated = $request->validate([
                'full_name' => 'required|string|max:150',
                'email' => 'required|string|max:150',
                'phone' => 'required|string|max:20',
                'date_of_birth' => 'required|date',
                'nationality' => 'required|string|max:100',
                'gender' => 'required|in:Male,Female,Other',
                'relationship' => 'required|string|max:50'
            ]);
        } else {
            // PATCH: partial update, only validate provided fields
            $validated = $request->validate([
                'full_name' => 'sometimes|string|max:150',
                'email' => 'sometimes|string|max:150',
                'phone' => 'sometimes|string|max:20',
                'date_of_birth' => 'sometimes|date',
                'nationality' => 'sometimes|string|max:100',
                'gender' => 'sometimes|in:Male,Female,Other',
                'relationship' => 'sometimes|string|max:50'
            ]);
        }

        $additionalApplicant->update($validated);

        return response()->json($additionalApplicant, 200);
    }

    // Delete additional applicant
    public function destroy($applicationId, $id)
    {
        $additionalApplicant = AdditionalApplicant::where('application_id', $applicationId)
            ->where('additional_applicant_id', $id)
            ->firstOrFail();
        if (!$additionalApplicant) {
            return response()->json(['message' => 'Additional applicant details not found'], 404);
        }
        $additionalApplicant->delete();

        return response()->json(['message' => 'Additional applicant deleted successfully'], 200);
    }
}