<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaPreviousUkVisa;
use Illuminate\Http\Request;

class PreviousUkVisaController extends Controller
{
    // List all the previous UK visa details for a given application
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->previousUkVisa, 200);
    }

    // Add a previous UK visa details
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'visa_type'       => 'required|string|max:100',
            'issue_date'      => 'required|date',
            'expiry_date'     => 'required|date|after_or_equal:issue_date',
            'visa_number'     => 'required|string|max:50',
            'purpose_of_visit'=> 'nullable|string',
            'issues'          => 'nullable|string',
        ]);

        $previousUkVisa = $application->previousUkVisa()->create($validated);

        return response()->json($previousUkVisa, 201);
    }

    // Show one previous UK visa detail
    public function show($applicationId, $previousUkVisaId)
    {
        $previousUkVisa = VisaPreviousUkVisa::where('application_id', $applicationId)
                                       ->where('previous_visa_id', $previousUkVisaId)
                                       ->firstOrFail();
        return response()->json($previousUkVisa, 200);
    }

    // Update previous UK visa detail
    public function update(Request $request, $applicationId, $previousUkVisaId)
    {
        $previousUkVisa = VisaPreviousUkVisa::where('application_id', $applicationId)
                                   ->where('previous_visa_id', $previousUkVisaId)
                                   ->firstOrFail();

        if ($request->isMethod('put')) {   
        // Full update: require all fields                       
        $validated = $request->validate([
            'visa_type'       => 'required|string|max:100',
            'issue_date'      => 'required|date',
            'expiry_date'     => 'required|date|after_or_equal:issue_date',
            'visa_number'     => 'required|string|max:50',
            'purpose_of_visit'=> 'nullable|string',
            'issues'          => 'nullable|string',
        ]);
    } else {
        // PATCH: partial update, only validate provided fields
        $validated = $request->validate([
            'visa_type'       => 'sometimes|string|max:100',
            'issue_date'      => 'sometimes|date',
            'expiry_date'     => 'sometimes|date|after_or_equal:issue_date',
            'visa_number'     => 'sometimes|string|max:50',
            'purpose_of_visit'=> 'sometimes|nullable|string',
            'issues'          => 'sometimes|nullable|string',
        ]);
    }

        if (!$previousUkVisa) {
            return response()->json(['message' => 'Previous UK visa details not found'], 404);
        }

        $previousUkVisa->update($validated);

        return response()->json($previousUkVisa, 200);
    }

    // Delete previous Uk Visa
    public function destroy($applicationId, $previousUkVisaId)
    {
        $previousUkVisa = VisaPreviousUkVisa::where('application_id', $applicationId)
                                  ->where('previous_visa_id', $previousUkVisaId)
                                  ->firstOrFail();
        $previousUkVisa->delete();

        return response()->json(['message' => 'Dependent deleted successfully'], 200);
    }
}