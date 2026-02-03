<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaPackage;
use Illuminate\Http\Request;

class VisaPackageController extends Controller
{
    // List all the visa package details for a given application
    public function index($applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);
        return response()->json($application->package, 200);
    }

    // Add a visa package details
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'package_name'       => 'required|string|max:150',
            'visa_type'      => 'required|string|max:100',
            'base_price'     => 'required|numeric|min:0'
        ]);

        $package = $application->package()->create($validated);

        return response()->json($package, 201);
    }

    // Show one visa package detail based on applicationId and packageId
    public function show($applicationId, $packageId)
    {
        $package = VisaPackage::where('application_id', $applicationId)
                                       ->where('package_id', $packageId)
                                       ->firstOrFail();
        return response()->json($package, 200);
    }

    // Update all or some fields in visa package detail
    public function update(Request $request, $applicationId, $packageId)
    {
        $package = VisaPackage::where('application_id', $applicationId)
                                   ->where('package_id', $packageId)
                                   ->firstOrFail();
        if (!$package) {
        return response()->json(['message' => 'Visa package details not found'], 404);
        }

        if ($request->isMethod('put')) {
                // Full update: require all fields                       
                $validated = $request->validate([
                    'package_name'       => 'required|string|max:150',
                    'visa_type'      => 'required|string|max:100',
                    'base_price'     => 'required|numeric|min:0'
                ]);
        } else {
                // PATCH: partial update, only validate provided fields
                $validated = $request->validate([
                    'package_name'       => 'sometimes|string|max:150',
                    'visa_type'      => 'sometimes|string|max:100',
                    'base_price'     => 'sometimes|numeric|min:0'
                ]);
        }   

        $package->update($validated);

        return response()->json($package, 200);
    }

    // Delete visa package details
    public function destroy($applicationId, $packageId)
    {
        $package = VisaPackage::where('application_id', $applicationId)
                                  ->where('package_id', $packageId)
                                  ->firstOrFail();
        $package->delete();

        return response()->json(['message' => 'Visa package details deleted successfully'], 200);
    }
}