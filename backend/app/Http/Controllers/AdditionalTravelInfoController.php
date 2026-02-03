<?php

namespace App\Http\Controllers;

use App\Models\AdditionalApplicant;
use App\Models\AdditionalTravelInfo;
use Illuminate\Http\Request;

class AdditionalTravelInfoController extends Controller
{

    // List all travel information for a given additional applicant
    public function index($applicantId)
    {
        $additionalapplicant = AdditionalApplicant::findOrFail($applicantId);
        return response()->json($additionalapplicant->travelInfo, 200);
    }

    // store travel information for a given additional applicant
    public function store(Request $request, $applicantId)
    {
        $additionalapplicant = AdditionalApplicant::findOrFail(id: $applicantId);

        $validated = $request->validate([
            'destination_country' => 'required|string|max:100',
            'departure_date' => 'required|date',
            'return_date' => 'required|date',
            'purpose_of_travel' => 'required|string|max:150',
            'accommodation_type' => 'required|string|max:50',
            'accommodation_details' => 'nullable|string|max:2000'
        ]);

        $additionalTravelInfo = $additionalapplicant->travelInfo()->create($validated);

        return response()->json($additionalTravelInfo, 201);
    }

    // Show travel information for an additional applicant based on ID
    public function show($applicantId, $id)
    {
        $additionalTravelInfo = AdditionalTravelInfo::where('additional_applicant_id', $applicantId)
            ->where('id', $id)
            ->firstOrFail();
        return response()->json($additionalTravelInfo, 200);
    }

    // Update additional Travel Information fully or partially (PUT/PATCH)
    public function update(Request $request, $applicantId, $id)
    {
        $additionalTravelInfo = AdditionalTravelInfo::where('additional_applicant_id', $applicantId)
            ->where('id', $id)
            ->firstOrFail();
        if (!$additionalTravelInfo) {
            return response()->json(['message' => 'Additional applicant travel info not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'destination_country' => 'required|string|max:100',
                'departure_date' => 'required|date',
                'return_date' => 'required|date',
                'purpose_of_travel' => 'required|string|max:150',
                'accommodation_type' => 'required|string|max:50',
                'accommodation_details' => 'nullable|string|max:2000'
            ]);
        } else {
            $validated = $request->validate([
                'destination_country' => 'sometimes|string|max:100',
                'departure_date' => 'sometimes|date',
                'return_date' => 'sometimes|date',
                'purpose_of_travel' => 'sometimes|string|max:150',
                'accommodation_type' => 'sometimes|string|max:50',
                'accommodation_details' => 'sometimes|nullable|string|max:2000'
            ]);
        }
        $additionalTravelInfo->update($validated);

        return response()->json($additionalTravelInfo, 200);
    }

    // Delete additional applicant travel information
    public function destroy($applicantId, $id)
    {
        $additionalTravelInfo = AdditionalTravelInfo::where('additional_applicant_id', $applicantId)
            ->where('id', $id)
            ->firstOrFail();

        if (!$additionalTravelInfo) {
            return response()->json(['message' => 'Additional applicant travel info not found'], 404);
        }

        $additionalTravelInfo->delete();

        return response()->json(['message' => 'Additional applicant travel info deleted'], 200);
    }
}