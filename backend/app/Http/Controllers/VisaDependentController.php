<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaDependent;
use Illuminate\Http\Request;

class VisaDependentController extends Controller
{
    // List dependents for a given application
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->dependents, 200);
    }

    // Add a dependent
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'relationship' => 'required|in:Partner,Child,Adult Relative',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:100',
            'passport_number' => 'required|string|max:50'
        ]);

        $dependent = $application->dependents()->create($validated);

        return response()->json($dependent, 201);
    }

    // Show one dependent
    public function show($applicationId, $dependentId)
    {
        $dependent = VisaDependent::where('application_id', $applicationId)
            ->where('dependent_id', $dependentId)
            ->firstOrFail();
        return response()->json($dependent, 200);
    }

    // Update dependent
    public function update(Request $request, $applicationId, $dependentId)
    {
        $dependent = VisaDependent::where('application_id', $applicationId)
            ->where('dependent_id', $dependentId)
            ->firstOrFail();
        if (!$dependent) {
            return response()->json(['message' => 'Visa dependent details not found'], 404);
        }

        if ($request->isMethod('put')) {
            // Full update: require all fields                       
            $validated = $request->validate([
                'full_name' => 'string|max:150',
                'relationship' => 'in:Partner,Child,Adult Relative',
                'date_of_birth' => 'date',
                'nationality' => 'required|string|max:100',
                'passport_number' => 'required|string|max:50'
            ]);
        } else {
            // PATCH: partial update, only validate provided fields
            $validated = $request->validate([
                'full_name' => 'sometimes|max:150',
                'relationship' => 'sometimes|in:Partner,Child,Adult Relative',
                'date_of_birth' => 'sometimes|date',
                'nationality' => 'sometimes|max:100|nullable',
                'passport_number' => 'sometimes|max:50|nullable'
            ]);
        }

        $dependent->update($validated);

        return response()->json($dependent, 200);
    }

    // Delete dependent
    public function destroy($applicationId, $dependentId)
    {
        $dependent = VisaDependent::where('application_id', $applicationId)
            ->where('dependent_id', $dependentId)
            ->firstOrFail();
        $dependent->delete();

        return response()->json(['message' => 'Visa dependent deleted successfully'], 200);
    }
}