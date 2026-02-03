<?php

namespace App\Http\Controllers;

use App\Models\CustomerResponse;
use Illuminate\Http\Request;

class CustomerResponseController extends Controller
{
    // CREATE a new customer response
    public function store(Request $request, $sessionId)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer|min:1',
            'question_text' => 'required|string',
            'option_text' => 'required|string|max:255',
            'response_text' => 'nullable|string',
        ]);
        $validated['session_id'] = $sessionId;
        $response = CustomerResponse::create($validated);
        return response()->json($response, 201);
    }

    // READ all customer responses
    public function index($sessionId)
    {
        $customerResponse = CustomerResponse::where('session_id', $sessionId)->get();
        return response()->json($customerResponse, 200);
    }

    // READ a specific customer response based on ID
    public function show($sessionId, $id)
    {
        $response = CustomerResponse::where('session_id', $sessionId)
            ->findOrFail($id);
        return response()->json($response, 200);
    }

    // UPDATE a customer response fully or partially (PUT/PATCH)
    public function update(Request $request, $sessionId, $id)
    {
        $response = CustomerResponse::where('session_id', $sessionId)
            ->findOrFail($id);

        if (!$response) {
            return response()->json(['message' => 'Customer Response not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'step_number' => 'required|integer|min:1',
                'question_text' => 'required|string',
                'option_text' => 'required|string|max:255',
                'response_text' => 'nullable|string',
            ]);
        } else {
            $validated = $request->validate([
                'step_number' => 'sometimes|integer|min:1',
                'question_text' => 'sometimes|string',
                'option_text' => 'sometimes|string|max:255',
                'response_text' => 'sometimes|nullable|string',
            ]);
        }

        $response->update($validated);
        return response()->json($response, 200);
    }

    // DELETE a customer response
    public function destroy($sessionId, $id)
    {
        $response = CustomerResponse::where('session_id', $sessionId)
            ->findOrFail($id);
        if (!$response) {
            return response()->json(['message' => 'Customer details not found'], 404);
        }

        $response->delete();
        return response()->json(['message' => 'Customer details deleted successfully']);
    }
}