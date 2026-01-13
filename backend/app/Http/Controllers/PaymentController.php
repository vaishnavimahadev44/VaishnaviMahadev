<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // List all payments for an application
    public function index($applicationId)
    {
        $payments = Payment::where('application_id', $applicationId)->get();
        return response()->json($payments, 200);
    }

    // Store a new payment
    public function store(Request $request, $applicationId)
    {
        $validated = $request->validate([
            'payment_method'       => 'required|in:PAYPAL_GUEST,PAYPAL_ACCOUNT,PAY_LATER',
            'payment_status'       => 'required|in:INITIATED,PAID,FAILED,EMAIL_SENT',
            'amount'               => 'required|numeric|min:0',
            'currency'             => 'required|string|max:10',
            'transaction_reference'=> 'required|string|max:100'
        ]);

        $validated['application_id'] = $applicationId;

        $payment = Payment::create($validated);

        return response()->json($payment, 201);
    }

    // Show a specific payment
    public function show($applicationId, $id)
    {
        $payment = Payment::where('application_id', $applicationId)
                          ->findOrFail($id);
        return response()->json($payment, 200);
    }

    // Update a payment fully(PUT) or partially(PATCH)
    public function update(Request $request, $applicationId, $id)
    {
        $payment = Payment::where('application_id', $applicationId)
                          ->findOrFail($id);

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'payment_method'       => 'required|in:PAYPAL_GUEST,PAYPAL_ACCOUNT,PAY_LATER',
                'payment_status'       => 'required|in:INITIATED,PAID,FAILED,EMAIL_SENT',
                'amount'               => 'required|numeric|min:0',
                'currency'             => 'required|string|max:10',
                'transaction_reference'=> 'required|string|max:100'
            ]);
        } else {
            $validated = $request->validate([
            'payment_method'       => 'sometimes|in:PAYPAL_GUEST,PAYPAL_ACCOUNT,PAY_LATER',
            'payment_status'       => 'sometimes|in:INITIATED,PAID,FAILED,EMAIL_SENT',
            'amount'               => 'sometimes|numeric|min:0',
            'currency'             => 'sometimes|string|max:10',
            'transaction_reference'=> 'sometimes|string|max:100'
            ]); 
        }

        if (!$payment) {
            return response()->json(['message' => 'Visa Payment not found'], 404);
        }
        $payment->update($validated);

        return response()->json($payment, 200);
    }

    // Delete a payment
    public function destroy($applicationId, $id)
    {
        $payment = Payment::where('application_id', $applicationId)
                          ->findOrFail($id);
        $payment->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}