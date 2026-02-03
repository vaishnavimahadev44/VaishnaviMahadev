<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // List all customer details for a session
    public function index($sessionId)
    {
        $customer = Customer::where('session_id', $sessionId)->get();
        return response()->json($customer, 200);
    }

    // Store new customer detail
    public function store(Request $request, $sessionId)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:20',
            'purchase_intent' => 'required|in:YES,NO',
            'address' => 'nullable|string',
        ]);

        $validated['session_id'] = $sessionId;

        $customer = Customer::create($validated);

        return response()->json($customer, 201);
    }

    // Show a specific customer detail
    public function show($sessionId, $id)
    {
        $customer = Customer::where('session_id', $sessionId)
            ->findOrFail($id);
        return response()->json($customer, 200);
    }

    // Update a customer detail fully or partially (PUT/PATCH)
    public function update(Request $request, $sessionId, $id)
    {

        $customer = Customer::where('session_id', $sessionId)
            ->findOrFail($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer details not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'full_name' => 'required|string|max:150',
                'email' => 'required|email|max:150',
                'phone' => 'required|string|max:20',
                'purchase_intent' => 'required|in:YES,NO',
                'address' => 'nullable|string',
            ]);
        } else {
            $validated = $request->validate([
                'full_name' => 'sometimes|string|max:150',
                'email' => 'sometimes|email|max:150',
                'phone' => 'sometimes|string|max:20',
                'purchase_intent' => 'sometimes|in:YES,NO',
                'address' => 'sometimes|nullable|string',
            ]);
        }

        $customer->update($validated);

        return response()->json($customer, 200);
    }

    // Delete a customer detail
    public function destroy($sessionId, $id)
    {
        $customer = Customer::where('session_id', $sessionId)
            ->findOrFail($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer details not found'], 404);
        }
        $customer->delete();

        return response()->json(['message' => 'Customer details deleted successfully'], 200);
    }
}