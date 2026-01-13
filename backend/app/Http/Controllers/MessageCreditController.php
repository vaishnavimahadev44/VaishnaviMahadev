<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\MessageCreditOption;
use Illuminate\Http\Request;

class MessageCreditController extends Controller
{
    // List all the message credit option details for a given application
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->messageCredits, 200);
    }

    // Add a message credit option detail
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'credits'      => 'required|integer|min:1',
            'price'        => 'required|numeric|min:0'
        ]);

        $messageCredit = $application->messageCredits()->create($validated);

        return response()->json($messageCredit, 201);
    }

    // Show one message credit detail based on applicationId and messageCreditId
    public function show($applicationId, $messageCreditId)
    {
        $messageCredit = MessageCreditOption::where('application_id', $applicationId)
                                       ->where('credit_id', $messageCreditId)
                                       ->firstOrFail();
        return response()->json($messageCredit, 200);
    }

    // Update all or some fields in message credit option detail
    public function update(Request $request, $applicationId, $messageCreditId)
    {
        $messageCredit = MessageCreditOption::where('application_id', $applicationId)
                                   ->where('credit_id', $messageCreditId)
                                   ->firstOrFail();

        if ($request->isMethod('put')) {   
        // Full update: require all fields                       
        $validated = $request->validate([
            'credits'      => 'required|integer|min:1',
            'price'        => 'required|numeric|min:0'        ]);
    } else {
        // PATCH: partial update, only validate provided fields
        $validated = $request->validate([
            'credits'      => 'sometimes|integer|min:1',
            'price'        => 'sometimes|numeric|min:0'
        ]);
    }

        if (!$messageCredit) {
            return response()->json(['message' => 'Message Credit options not found'], 404);
        }

        $messageCredit->update($validated);

        return response()->json($messageCredit, 200);
    }

    // Delete message credit option details
    public function destroy($applicationId, $messageCreditId)
    {
        $messageCredit = MessageCreditOption::where('application_id', $applicationId)
                                  ->where('credit_id', $messageCreditId)
                                  ->firstOrFail();
        $messageCredit->delete();

        return response()->json(['message' => 'Dependent deleted successfully'], 200);
    }
}