<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\TravelInfo;
use Illuminate\Http\Request;

class TravelInfoController extends Controller
{
    // List all travel information for an application
    public function index($applicationId)
    {
        $travelInfo = TravelInfo::where('application_id', $applicationId)->get();
        return response()->json($travelInfo, 200);
    }

    // Store new travel information
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        $validated = $request->validate([
            'destination_country' => 'required|string|max:100',
            'departure_date' => 'required|date',
            'return_date' => 'required|date',
            'purpose_of_travel' => 'required|string|max:150',
            'accommodation_details' => 'nullable|string|max:2000'
        ]);

        $travelInfo = $application->travelInfo()->create($validated);

        return response()->json($travelInfo, 201);
    }

    // Show a specific travel information
    public function show($applicationId, $id)
    {
        $travelInfo = TravelInfo::where('application_id', $applicationId)
            ->findOrFail($id);
        return response()->json($travelInfo, 200);
    }

    // Update a travel information fully or partially (PUT/PATCH)
    public function update(Request $request, $applicationId, $id)
    {

        $travelInfo = TravelInfo::where('application_id', $applicationId)
            ->findOrFail($id);

        if (!$travelInfo) {
            return response()->json(['message' => 'Travel Information not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'destination_country' => 'required|string|max:100',
                'departure_date' => 'required|date',
                'return_date' => 'required|date',
                'purpose_of_travel' => 'required|string|max:150',
                'accommodation_details' => 'nullable|string|max:2000'
            ]);
        } else {
            $validated = $request->validate([
                'destination_country' => 'sometimes|string|max:100',
                'departure_date' => 'sometimes|date',
                'return_date' => 'sometimes|date',
                'purpose_of_travel' => 'sometimes|string|max:150',
                'accommodation_details' => 'sometimes|nullable|string|max:2000'
            ]);
        }

        $travelInfo->update($validated);

        return response()->json($travelInfo, 200);
    }

    // Delete a travel information
    public function destroy($applicationId, $id)
    {
        $travelInfo = TravelInfo::where('application_id', $applicationId)
            ->findOrFail($id);
        if (!$travelInfo) {
            return response()->json(['message' => 'Travel Information not found'], 404);
        }
        $travelInfo->delete();

        return response()->json(['message' => 'Travel Information deleted successfully'], 200);
    }
}