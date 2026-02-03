<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ClientVisa;

class EvisaController extends Controller
{
    // POST /evisa → save a new record
    public function store(Request $request)
    {

        // Validate incoming request
        $validated = $request->validate([
            'passport_no' => 'required|string|max:50',
            'applicant_name' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'visa_type' => 'required|in:tourist,business,student,work',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Save to database
        $visa = ClientVisa::create($validated);

        // Return API response
        return response()->json([
            'status' => 'success',
            'message' => 'Visa record stored successfully',
            'data' => $visa
        ], 201);
    }

    // GET /evisa → list all records
    public function index()
    {
        $visas = ClientVisa::all();
        return response()->json($visas);
    }

    // GET /evisa/{id} → show a single record
    public function show($id)
    {
        $visa = ClientVisa::findOrFail($id);
        return response()->json($visa);
    }

    // PUT/PATCH /evisa/{id} → update an existing record
    public function update(Request $request, $id)
    {
        $visa = ClientVisa::findOrFail($id);

        $validated = $request->validate([
            'passport_no' => 'string|max:50',
            'applicant_name' => 'string|max:255',
            'country' => 'string|max:100',
            'visa_type' => 'in:tourist,business,student,work',
            'status' => 'in:pending,approved,rejected',
        ]);

        $visa->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Visa record updated successfully',
            'data' => $visa
        ]);
    }

    // DELETE /evisa/{id} → delete a record
    public function destroy($id)
    {
        $visa = ClientVisa::findOrFail($id);
        $visa->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Visa record deleted successfully'
        ]);
    }
}