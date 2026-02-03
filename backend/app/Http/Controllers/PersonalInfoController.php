<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;

class PersonalInfoController extends Controller
{
    // List all personal information for an application
    public function index($applicationId)
    {
        $personalInfo = PersonalInfo::where('application_id', $applicationId)->get();
        return response()->json($personalInfo, 200);
    }

    // Store new personal information
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'primary_phone' => 'required|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:150',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
        ]);


        $personalInfo = $application->personalInfo()->create($validated);

        return response()->json($personalInfo, 201);
    }

    // Show a specific personal information
    public function show($applicationId, $id)
    {
        $personalInfo = PersonalInfo::where('application_id', $applicationId)
            ->findOrFail($id);
        return response()->json($personalInfo, 200);
    }

    // Update a personal information fully or partially (PUT/PATCH)
    public function update(Request $request, $applicationId, $id)
    {

        $personalInfo = PersonalInfo::where('application_id', $applicationId)
            ->findOrFail($id);
            
        if (!$personalInfo) {
            return response()->json(['message' => 'Personal Information not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'full_name' => 'required|string|max:150',
                'primary_phone' => 'required|string|max:20',
                'alternate_phone' => 'nullable|string|max:20',
                'email' => 'required|email|max:150',
                'street_address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
                'gender' => 'required|in:Male,Female,Other'
            ]);
        } else {
            $validated = $request->validate([
                'full_name' => 'sometimes|string|max:150',
                'primary_phone' => 'sometimes|string|max:20',
                'alternate_phone' => 'sometimes|nullable|string|max:20',
                'email' => 'sometimes|email|max:150',
                'street_address' => 'sometimes|string|max:255',
                'city' => 'sometimes|string|max:100',
                'state' => 'sometimes|string|max:100',
                'postal_code' => 'sometimes|string|max:20',
                'gender' => 'sometimes|in:Male,Female,Other'
            ]);
        }

        $personalInfo->update($validated);

        return response()->json($personalInfo, 200);
    }

    // Delete a personal information
    public function destroy($applicationId, $id)
    {
        $personalInfo = PersonalInfo::where('application_id', $applicationId)
            ->findOrFail($id);
        if (!$personalInfo) {
            return response()->json(['message' => 'Personal Information not found'], 404);
        }
        $personalInfo->delete();

        return response()->json(['message' => 'Personal Information deleted successfully'], 200);
    }
}