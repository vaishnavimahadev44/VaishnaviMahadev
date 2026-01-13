<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaPreviousIssue;
use Illuminate\Http\Request;

class VisaPreviousIssueController extends Controller
{
    //List all visa issues or refusal details based on applicationId
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->previousIssue, 200);
    }

    //create a new visa issue Or refusal details based on applicationId 
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'issue_type' => 'required|string|max:100',
            'issue_date' => 'required|date',
            'country' => 'required|string|max:100',
            'description' => 'nullable|string',
            'resolution_status' => 'in:Resolved,Pending,Rejected'
        ]);

        $issueOrRefusalId = $application->previousIssue()->create($validated);

        return response()->json($issueOrRefusalId, 201);
    }

    //Get a visa issue/refusal details based on applicationId and issueId
    public function show($applicationId, $id)
    {
        $issueOrRefusalId = VisaPreviousIssue::where('application_id', $applicationId)
                                ->where('issue_id', $id)
                                ->firstOrFail();
        return response()->json($issueOrRefusalId, 200);
    }

    //Update All or few fields based on applicationId and issueId
    public function update(Request $request, $applicationId, $id)
    {
        $issueOrRefusalDetails = VisaPreviousIssue::where('application_id', $applicationId)
                                ->where('issue_id', $id)
                                ->firstOrFail();

        if ($request->isMethod('put')) {
            // Full update
            $validated = $request->validate([
                'issue_type' => 'required|string|max:100',
                'issue_date' => 'required|date',
                'country' => 'required|string|max:100',
                'description' => 'nullable|string',
                'resolution_status' => 'required|in:Resolved,Pending,Rejected'
            ]);
        } else {
            // PATCH: partial update
            $validated = $request->validate([
                'issue_type' => 'sometimes|string|max:100',
                'issue_date' => 'sometimes|date',
                'country' => 'sometimes|string|max:100',
                'description' => 'sometimes|string',
                'resolution_status' => 'sometimes|in:Resolved,Pending,Rejected'
            ]);
        }

        if (!$issueOrRefusalDetails) {
            return response()->json(['message' => 'Visa Issue/Refusal details not found'], 404);
        }
        $issueOrRefusalDetails->update($validated);

        return response()->json($issueOrRefusalDetails, 200);
    }
    
    //delete the visa previous visa issue details based on applicationId and issueId
    public function destroy($applicationId, $id)
    {
        $issueOrRefusalId = VisaPreviousIssue::where('application_id', $applicationId)
                                ->where('issue_id', $id)
                                ->firstOrFail();
        $issueOrRefusalId->delete();

        return response()->json(['message' => 'issueOrRefusal details deleted successfully'], 200);
    }
}