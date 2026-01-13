<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\PrimaryApplicant;
use Illuminate\Http\Request;

class PrimaryApplicantController extends Controller
{
    /**
     * Display a listing of primary applicants.
     */
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->primaryApplicant, 200);
    }

    /**
     * Store a newly created primary applicant.
     */
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        $validated = $request->validate([
            'full_name'      => 'required|string|max:150',
            'email'          => 'required|email|max:150',
            'phone_number'   => 'required|string|max:20',
        ]);

        $applicant = $application->primaryApplicant()->create($validated);

        return response()->json($applicant, 201);
    }

    /**
     * Display a specific primary applicant.
     */
    public function show($applicationId, $id)
    {
        $applicant = PrimaryApplicant::where('application_id', $applicationId)
                                     ->findOrFail($id);
        return response()->json($applicant, 200);
    }

    /**
     * Update a primary applicant (PUT = full update) 
     * OR Partially update a primary applicant (PATCH).
     */
    public function update(Request $request, $applicationId, $id)
    {
        $applicant = PrimaryApplicant::where('application_id', $applicationId)
                                     ->findOrFail($id);
                                     
        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'full_name'      => 'required|string|max:150',
                'email'          => 'required|email|max:150',
                'phone_number'   => 'required|string|max:20'
            ]);
        } else {
            $validated = $request->validate([
                'full_name'      => 'sometimes|string|max:150',
                'email'          => 'sometimes|email|max:150',
                'phone_number'   => 'sometimes|string|max:20'
            ]);
        }

        if (!$applicant) {
            return response()->json(['message' => 'Primary applicant not found'], 404);
        }
        $applicant->update($validated);

        return response()->json($applicant, 200);
    }

    /**
     * Remove a primary applicant.
     */
    public function destroy($applicationId, $id)
    {
        $applicant = PrimaryApplicant::where('application_id', $applicationId)
                                     ->findOrFail($id);
        $applicant->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}