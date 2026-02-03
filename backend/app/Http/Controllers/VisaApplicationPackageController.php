<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\ApplicationPackage;
use Illuminate\Http\Request;

class VisaApplicationPackageController extends Controller
{
    // List all packages for an application
    public function index($applicationId)
    {
        $packages = ApplicationPackage::where('application_id', $applicationId)->get();
        return response()->json($packages, 200);
    }

    // Store a new application package
    public function store(Request $request, $applicationId)
    {
        $application = VisaApplication::findOrFail($applicationId);

        $validated = $request->validate([
            'package_id' => 'required|exists:visa_packages,package_id',
            'credit_id' => 'nullable|exists:message_credit_options,credit_id',
            'total_price' => 'required|numeric|min:0',
        ]);

        $appPackage = $application->applicationPackages()->create($validated);

        return response()->json($appPackage, 201);
    }

    // Show a specific application package
    public function show($applicationId, $id)
    {
        $package = ApplicationPackage::where('application_id', $applicationId)
            ->findOrFail($id);
        return response()->json($package, 200);
    }

    // Update an application package fully or partially
    public function update(Request $request, $applicationId, $id)
    {
        $package = ApplicationPackage::where('application_id', $applicationId)
            ->findOrFail($id);
        if (!$package) {
            return response()->json(['message' => 'Visa Application package details not found'], 404);
        }

        if ($request->isMethod('put')) {
            // Full update
            $validated = $request->validate([
                'package_id' => 'required|exists:visa_packages,package_id',
                'credit_id' => 'nullable|exists:message_credit_options,credit_id',
                'total_price' => 'required|numeric|min:0',
            ]);
        } else {
            // Partial update
            $validated = $request->validate([
                'package_id' => 'sometimes|exists:visa_packages,package_id',
                'credit_id' => 'nullable|exists:message_credit_options,credit_id',
                'total_price' => 'sometimes|numeric|min:0',
            ]);
        }

        $package->update($validated);

        return response()->json($package, 200);
    }

    // Delete an application package
    public function destroy($applicationId, $id)
    {
        $package = ApplicationPackage::where('application_id', $applicationId)
            ->findOrFail($id);
        $package->delete();

        return response()->json(['message' => 'Visa Application package deleted successfully'], 200);
    }
}