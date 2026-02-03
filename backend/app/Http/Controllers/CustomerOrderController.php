<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    // List all orders for a customer
    public function index($customerId)
    {
        $orders = Order::where('customer_id', $customerId)->get();
        return response()->json($orders, 200);
    }

    // Store new order for a customer
    public function store(Request $request, $customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $validated = $request->validate([
            'template_name' => 'required|string|max:150',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Paid,Completed,Cancelled',
        ]);

        $order = $customer->orders()->create($validated);

        return response()->json($order, 201);
    }

    // Show a specific order for a customer 
    public function show($customerId, $id)
    {
        $order = Order::where('customer_id', $customerId)
            ->findOrFail($id);
        return response()->json($order, 200);
    }

    // Update a customer order fully or partially (PUT/PATCH)
    public function update(Request $request, $customerId, $id)
    {

        $order = Order::where('customer_id', $customerId)
            ->findOrFail($id);
        if (!$order) {
            return response()->json(['message' => 'Order details for a customer not found'], 404);
        }

        if ($request->isMethod('put')) {
            $validated = $request->validate([
                'template_name' => 'required|string|max:150',
                'total_price' => 'required|numeric|min:0',
                'status' => 'required|in:Pending,Paid,Completed,Cancelled',
            ]);
        } else {
            $validated = $request->validate([
                'template_name' => 'sometimes|string|max:150',
                'total_price' => 'sometimes|numeric|min:0',
                'status' => 'sometimes|in:Pending,Paid,Completed,Cancelled',
            ]);
        }

        $order->update($validated);

        return response()->json($order, 200);
    }

    // Delete an order for a customer
    public function destroy($customerId, $id)
    {
        $order = Order::where('customer_id', $customerId)
            ->findOrFail($id);
        if (!$order) {
            return response()->json(['message' => 'Order details for a customer not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}