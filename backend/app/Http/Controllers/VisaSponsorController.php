<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaSponsor;
use Illuminate\Http\Request;

class VisaSponsorController extends Controller
{
    // List all the visa sponsor details for a given application
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->sponsor, 200);
    }

    // Add a visa sponsor details
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'sponsor_type'       => 'required|string|max:100',
            'sponsor_name'      => 'required|string|max:150',
            'sponsor_email'     => 'required|string|max:150',
            'sponsor_phone'     => 'required|string|max:50',
            'sponsor_address' => 'required|string|max:2000',
            'sponsor_details' => 'nullable|string|max:2000'
        ]);

        $sponsor = $application->sponsor()->create($validated);

        return response()->json($sponsor, 201);
    }

    // Show one visa sponsor detail based on applicationId and sponsorId
    public function show($applicationId, $sponsorId)
    {
        $sponsor = VisaSponsor::where('application_id', $applicationId)
                                       ->where('sponsor_id', $sponsorId)
                                       ->firstOrFail();
        return response()->json($sponsor, 200);
    }

    // Update visa sponsor detail fully or partially
    public function update(Request $request, $applicationId, $sponsorId)
    {
        $sponsor = VisaSponsor::where('application_id', $applicationId)
                                   ->where('sponsor_id', $sponsorId)
                                   ->firstOrFail();

        if (!$sponsor) {
        return response()->json(['message' => 'Visa sponsor not found'], 404);
        }

        if ($request->isMethod('put')) {
        // Full update: require all fields                       
        $validated = $request->validate([
                'sponsor_type'       => 'required|string|max:100',
                'sponsor_name'      => 'required|string|max:150',
                'sponsor_email'     => 'required|string|max:150',
                'sponsor_phone'     => 'required|string|max:50',
                'sponsor_address' => 'required|string|max:2000',
                'sponsor_details' => 'nullable|string|max:2000'
        ]);
        } else {
        // PATCH: partial update, only validate provided fields
        $validated = $request->validate([
                'sponsor_type'       => 'sometimes|string|max:100',
                'sponsor_name'      => 'sometimes|string|max:150',
                'sponsor_email'     => 'sometimes|string|max:150',
                'sponsor_phone'     => 'sometimes|string|max:50',
                'sponsor_address' => 'sometimes|string|max:2000',
                'sponsor_details' => 'sometimes|string|nullable|max:2000'
            ]);
        }

        $sponsor->update($validated);

        return response()->json($sponsor, 200);
    }

    // Delete visa sponsor details
    public function destroy($applicationId, $sponsorId)
    {
        $sponsor = VisaSponsor::where('application_id', $applicationId)
                                  ->where('sponsor_id', $sponsorId)
                                  ->firstOrFail();
        if (!$sponsor) {
        return response()->json(['message' => 'Visa sponsor not found'], 404);
        }

        $sponsor->delete();

        return response()->json(['message' => 'Visa sponsor deleted successfully'], 200);
    }
}