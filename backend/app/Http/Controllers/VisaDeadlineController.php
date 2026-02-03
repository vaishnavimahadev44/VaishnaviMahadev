<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaDeadline;
use Illuminate\Http\Request;

class VisaDeadlineController extends Controller
{
    //List all visa deadlines based on applicationId
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->deadline, 200);
    }

    //create a new visa deadline based on applicationId 
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'deadline_date' => 'required|date',
            'reason' => 'nullable|string|max:255',
            'additional_details' => 'nullable|string'
        ]);

        $deadline = $application->deadline()->create($validated);

        return response()->json($deadline, 201);
    }

    //Get a visa deadline based on applicationId and deadlineId
    public function show($applicationId, $id)
    {
        $deadline = VisaDeadline::where('application_id', $applicationId)
            ->where('deadline_id', $id)
            ->firstOrFail();
        return response()->json($deadline, 200);
    }

    //Update All or few fields based on applicationId and deadlineId
    public function update(Request $request, $applicationId, $id)
    {
        $deadline = VisaDeadline::where('application_id', $applicationId)
            ->where('deadline_id', $id)
            ->firstOrFail();

        if ($request->isMethod('put')) {
            // Full update
            $validated = $request->validate([
                'deadline_date' => 'required|date',
                'reason' => 'required|string|max:255',
                'additional_details' => 'nullable|string'
            ]);
        } else {
            // PATCH: partial update
            $validated = $request->validate([
                'deadline_date' => 'sometimes|date',
                'reason' => 'sometimes|required|string|max:255',
                'additional_details' => 'nullable|string'
            ]);
        }

        if (!$deadline) {
            return response()->json(['message' => 'Visa deadline details not found'], 404);
        }
        $deadline->update($validated);

        return response()->json($deadline, 200);
    }

    //delete the visa deadline based on applicationId and deadlineId
    public function destroy($applicationId, $id)
    {
        $deadline = VisaDeadline::where('application_id', $applicationId)
            ->where('deadline_id', $id)
            ->firstOrFail();
        $deadline->delete();

        return response()->json(['message' => 'Visa deadline details deleted successfully'], 200);
    }
}