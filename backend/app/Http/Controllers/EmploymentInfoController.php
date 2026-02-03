<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\EmploymentInfo;
use Illuminate\Http\Request;

class EmploymentInfoController extends Controller
{
    // List all employment information for an application
    public function index($applicationId)
    {
        $employmentInfo = EmploymentInfo::where('application_id', $applicationId)->get();
        return response()->json($employmentInfo, 200);
    }

    // Store new employment information
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        $validated = $request->validate([
            'employer' => 'required|string|max:150',
            'job_title' => 'required|string|max:100',
            'work_address' => 'required|string|max:255',
            'work_phone' => 'required|string|max:20',
            'years_at_job' => 'required|integer|min:0|max:80',
            'employment_status' => 'required|in:Employed,Unemployed,Student,Retired,Self-Employed,Other',
            'annual_income' => 'required|numeric|min:20'
        ]);

        $employmentInfo = $application->employmentInfo()->create($validated);

        return response()->json($employmentInfo, 201);
    }

    // Show a specific employment information
    public function show($applicationId, $id)
    {
        $employmentInfo = EmploymentInfo::where('application_id', $applicationId)
            ->findOrFail($id);
        return response()->json($employmentInfo, 200);
    }

    // Update a employment information fully or partially (PUT/PATCH)
    public function update(Request $request, $applicationId, $id)
    {

        $employmentInfo = EmploymentInfo::where('application_id', $applicationId)
            ->findOrFail($id);

        if (!$employmentInfo) {
            return response()->json(['message' => 'Employment Information not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'employer' => 'required|string|max:150',
                'job_title' => 'required|string|max:100',
                'work_address' => 'required|string|max:255',
                'work_phone' => 'required|string|max:20',
                'years_at_job' => 'required|integer|min:0|max:80',
                'employment_status' => 'required|in:Employed,Unemployed,Student,Retired,Self-Employed,Other',
                'annual_income' => 'required|numeric|min:20'
            ]);
        } else {
            $validated = $request->validate([
                'employer' => 'sometimes|string|max:150',
                'job_title' => 'sometimes|string|max:100',
                'work_address' => 'sometimes|string|max:255',
                'work_phone' => 'sometimes|string|max:20',
                'years_at_job' => 'sometimes|integer|min:0|max:80',
                'employment_status' => 'sometimes|in:Employed,Unemployed,Student,Retired,Self-Employed,Other',
                'annual_income' => 'sometimes|numeric|min :20'
            ]);
        }

        $employmentInfo->update($validated);

        return response()->json($employmentInfo, 200);
    }

    // Delete a employment information
    public function destroy($applicationId, $id)
    {
        $employmentInfo = EmploymentInfo::where('application_id', $applicationId)
            ->findOrFail($id);
        if (!$employmentInfo) {
            return response()->json(['message' => 'Personal Information not found'], 404);
        }
        $employmentInfo->delete();

        return response()->json(['message' => 'Personal Information deleted successfully'], 200);
    }
}