<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\EligibilityInfo;
use Illuminate\Http\Request;

class EligibilityInfoController extends Controller
{
    /**
     * Display all the eligibility information for a given application.
     */
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        $eligibility = $application->eligibilityInfo; // one-to-one relation

        return response()->json($eligibility, 200);
    }

    /**
     * Store new eligibility information for a given application.
     */
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'email' => 'required|email|max:150',
            'nationality' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
        ]);

        $eligibility = $application->eligibilityInfo()->create($validated);

        return response()->json($eligibility, 201);
    }

    /**
     * Display a specific eligibility information.
     */
    public function show($applicationId, $id)
    {
        $applicant = EligibilityInfo::where('application_id', $applicationId)
            ->findOrFail($id);
        return response()->json($applicant, 200);
    }

    /**
     * Update eligibility information info fully or partially (PUT/PATCH).
     */
    public function update(Request $request, $applicationId, $id)
    {
        $eligibility = EligibilityInfo::where('application_id', $applicationId)
            ->findOrFail($id);

        if (!$eligibility) {
            return response()->json(['message' => 'Visa Eligibility info not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'email' => 'required|email|max:150',
                'nationality' => 'required|string|max:100',
                'date_of_birth' => 'required|date',
            ]);
        } else {
            $validated = $request->validate([
                'email' => 'sometimes|email|max:150',
                'nationality' => 'sometimes|string|max:100',
                'date_of_birth' => 'sometimes|date',
            ]);
        }

        $eligibility->update($validated);

        return response()->json($eligibility, 200);
    }

    /**
     * Delete eligibility information for a given application.
     */
    public function destroy($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        $eligibility = $application->eligibilityInfo;

        if (!$eligibility) {
            return response()->json(['message' => 'Eligibility info not found'], 404);
        }

        $eligibility->delete();

        return response()->json(['message' => 'Eligibility info deleted successfully'], 200);
    }
}