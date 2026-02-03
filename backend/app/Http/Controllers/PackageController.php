<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ClientPackage;

class PackageController extends Controller
{
    /**
     * POST /api/package
     * Store a new package
     */
    public function store(Request $request)
    {

        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        // Save to database
        $package = ClientPackage::create($validated);

        // Return API response
        return response()->json([
            'status' => 'success',
            'message' => 'package record stored successfully',
            'data' => $package
        ], 201);
    }
    /**
     * GET /api/package
     * List all package
     */
    public function index()
    {
        $package = ClientPackage::all();
        return response()->json($package);
    }

    /**
     * GET /api/package/{id}
     * Show a single package
     */
    public function show($id)
    {
        $package = ClientPackage::findOrFail($id);
        return response()->json($package);
    }

    /**
     * PUT/PATCH /api/package/{id}
     * Update an existing package
     */
    public function update(Request $request, $id)
    {
        $package = ClientPackage::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $package->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'package record updated successfully',
            'data' => $package
        ]);
    }

    /**
     * DELETE /api/package/{id}
     * delete a package
     */
    public function destroy($id)
    {
        $package = ClientPackage::findOrFail($id);
        $package->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'package record deleted successfully'
        ]);
    }
}