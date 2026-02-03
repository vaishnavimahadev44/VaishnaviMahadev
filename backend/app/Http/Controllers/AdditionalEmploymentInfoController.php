<?php

namespace App\Http\Controllers;

use App\Models\AdditionalApplicant;
use App\Models\AdditionalEmploymentInfo;
use Illuminate\Http\Request;

class AdditionalEmploymentInfoController extends Controller
{

    // List all employment information for a given additional applicant
    public function index($applicantId)
    {
        $additionalapplicant = AdditionalApplicant::findOrFail($applicantId);
        return response()->json($additionalapplicant->employmentInfo, 200);
    }

    // store employment information for a given additional applicant
    public function store(Request $request, $applicantId)
    {
        $additionalapplicant = AdditionalApplicant::findOrFail(id: $applicantId);

        $validated = $request->validate([
            'employer' => 'required|string|max:150',
            'job_title' => 'required|string|max:100',
            'work_address' => 'required|string|max:255',
            'work_phone' => 'required|string|max:20',
            'years_at_job' => 'required|integer|min:0|max:80',
            'employment_status' => 'required|in:Employed,Unemployed,Student,Retired,Self-Employed,Other',
            'annual_income_range' => 'required|string|max:50',
            'exact_annual_income' => 'required|numeric|min:0',
            'education_level' => 'required|string|max:50',
            'english_proficiency' => 'required|string|max:50',
        ]);

        $additionalEmploymentInfo = $additionalapplicant->employmentInfo()->create($validated);

        return response()->json($additionalEmploymentInfo, 201);
    }

    // Show employment information for an additional applicant based on ID
    public function show($applicantId, $id)
    {
        $additionalEmploymentInfo = AdditionalEmploymentInfo::where('additional_applicant_id', $applicantId)
            ->where('id', $id)
            ->firstOrFail();
        return response()->json($additionalEmploymentInfo, 200);
    }

    // Update additional Employment Information fully or partially (PUT/PATCH)
    public function update(Request $request, $applicantId, $id)
    {
        $additionalEmploymentInfo = AdditionalEmploymentInfo::where('additional_applicant_id', $applicantId)
            ->where('id', $id)
            ->firstOrFail();
        if (!$additionalEmploymentInfo) {
            return response()->json(['message' => 'Additional applicant employment info not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'employer' => 'required|string|max:150',
                'job_title' => 'required|string|max:100',
                'work_address' => 'required|string|max:255',
                'work_phone' => 'required|string|max:20',
                'years_at_job' => 'required|integer|min:0|max:80',
                'employment_status' => 'required|in:Employed,Unemployed,Student,Retired,Self-Employed,Other',
                'annual_income_range' => 'required|string|max:50',
                'exact_annual_income' => 'required|numeric|min:0',
                'education_level' => 'required|string|max:50',
                'english_proficiency' => 'required|string|max:50'
            ]);
        } else {
            $validated = $request->validate([
                'employer' => 'sometimes|string|max:150',
                'job_title' => 'sometimes|string|max:100',
                'work_address' => 'sometimes|string|max:255',
                'work_phone' => 'sometimes|string|max:20',
                'years_at_job' => 'sometimes|integer|min:0|max:80',
                'employment_status' => 'sometimes|in:Employed,Unemployed,Student,Retired,Self-Employed,Other',
                'annual_income_range' => 'sometimes|string|max:50',
                'exact_annual_income' => 'sometimes|numeric|min:0',
                'education_level' => 'sometimes|string|max:50',
                'english_proficiency' => 'sometimes|string|max:50'
            ]);
        }
        $additionalEmploymentInfo->update($validated);

        return response()->json($additionalEmploymentInfo, 200);
    }

    // Delete additional applicant employment information
    public function destroy($applicantId, $id)
    {
        $additionalEmploymentInfo = AdditionalEmploymentInfo::where('additional_applicant_id', $applicantId)
            ->where('id', $id)
            ->firstOrFail();

        if (!$additionalEmploymentInfo) {
            return response()->json(['message' => 'Additional applicant employment info not found'], 404);
        }

        $additionalEmploymentInfo->delete();

        return response()->json(['message' => 'Additional applicant employment info deleted'], 200);
    }
}