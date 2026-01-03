<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\EvisaController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TemplateBuyingController;
use App\Http\Controllers\VisaTypeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Example API routes
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'status' => 'success',
        'timestamp' => now()
    ]);
});

Route::get('/users', function () {
    return response()->json([
        'message' => 'Users endpoint',
        'data' => []
    ]);
});

// Delete API Routes - 16 Delete Operations
Route::delete('/users/{id}', [DeleteController::class, 'deleteUser']);
Route::delete('/applications/{id}', [DeleteController::class, 'deleteApplication']);
Route::delete('/categories/{id}', [DeleteController::class, 'deleteCategory']);
Route::delete('/departments/{id}', [DeleteController::class, 'deleteDepartment']);
Route::delete('/employees/{id}', [DeleteController::class, 'deleteEmployee']);
Route::delete('/projects/{id}', [DeleteController::class, 'deleteProject']);
Route::delete('/tasks/{id}', [DeleteController::class, 'deleteTask']);
Route::delete('/documents/{id}', [DeleteController::class, 'deleteDocument']);
Route::delete('/comments/{id}', [DeleteController::class, 'deleteComment']);
Route::delete('/notifications/{id}', [DeleteController::class, 'deleteNotification']);
Route::delete('/roles/{id}', [DeleteController::class, 'deleteRole']);
Route::delete('/permissions/{id}', [DeleteController::class, 'deletePermission']);
Route::delete('/clients/{id}', [DeleteController::class, 'deleteClient']);
Route::delete('/vendors/{id}', [DeleteController::class, 'deleteVendor']);
Route::delete('/assets/{id}', [DeleteController::class, 'deleteAsset']);
Route::delete('/audit-logs/{id}', [DeleteController::class, 'deleteAuditLog']);

// API Routes for evisa
Route::resource('/evisa', EvisaController::class);
// API Routes for package
Route::resource('/package', PackageController::class);
// API Routes for template
Route::resource('/template-buying', TemplateBuyingController::class);
// API Routes for visa type
Route::resource('/visa-type', VisaTypeController::class);
