<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use Illuminate\Http\Request;

class VisaApplicationController extends Controller
{
    // List all visa applications
    public function index()
    {
        return response()->json(VisaApplication::all(), 200);
    }

    // Create new application
    public function store(Request $request)
    {
        $validated = $request->validate([
            'visa_country' => 'string|max:50',
            'visa_type' => 'required|string|max:100',
            'has_dependents' => 'boolean',
            'has_deadline' => 'boolean',
            'has_previous_issues' => 'boolean',
            'has_previous_uk_visa' => 'boolean',
            'has_sponsor' => 'boolean',
            'application_status' => 'in:IN_PROGRESS,PACKAGE_SELECTED,PAYMENT_PENDING,PAID,ABANDONED'
        ]);

        $application = VisaApplication::create($validated);

        return response()->json($application, 201);
    }

    // Fetch single application
    public function show($id)
    {
        $application = VisaApplication::findOrFail($id);
        return response()->json($application, 200);
    }

    // Update application
    public function update(Request $request, $id)
    {
        $application = VisaApplication::findOrFail($id);
        if (!$application) {
            return response()->json(['message' => 'Visa Application details not found'], 404);
        }

        if ($request->isMethod('put')) {
            // Full update: require all fields
            $validated = $request->validate([
                'visa_country' => 'required|string|max:50',
                'visa_type' => 'required|string|max:100',
                'has_dependents' => 'required|boolean',
                'has_deadline' => 'required|boolean',
                'has_previous_issues' => 'required|boolean',
                'has_previous_uk_visa' => 'required|boolean',
                'has_sponsor' => 'required|boolean',
                'application_status' => 'required|in:IN_PROGRESS,PACKAGE_SELECTED,PAYMENT_PENDING,PAID,ABANDONED'
            ]);
        } else {
            // PATCH: partial update, only validate provided fields
            $validated = $request->validate([
                'visa_country' => 'sometimes|string|max:50',
                'visa_type' => 'sometimes|string|max:100',
                'has_dependents' => 'sometimes|boolean',
                'has_deadline' => 'sometimes|boolean',
                'has_previous_issues' => 'sometimes|boolean',
                'has_previous_uk_visa' => 'sometimes|boolean',
                'has_sponsor' => 'sometimes|boolean',
                'application_status' => 'sometimes|in:IN_PROGRESS,PACKAGE_SELECTED,PAYMENT_PENDING,PAID,ABANDONED'
            ]);
        }
    
        $application->update($validated);

        return response()->json($application, 200);
    }

    // Delete application
    public function destroy($id)
    {
        $application = VisaApplication::findOrFail($id);
        $application->delete();

        return response()->json(['message' => ' Visa Application deleted successfully'], 200);
    }

    
}