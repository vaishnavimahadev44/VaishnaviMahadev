<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\EvisaController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TemplateBuyingController;
use App\Http\Controllers\VisaTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VisaApplicationController;
use App\Http\Controllers\VisaDependentController;
use App\Http\Controllers\VisaDeadlineController;
use App\Http\Controllers\VisaPreviousIssueController;
use App\Http\Controllers\PreviousUkVisaController;
use App\Http\Controllers\VisaSponsorController;
use App\Http\Controllers\VisaPackageController;
use App\Http\Controllers\MessageCreditController;
use App\Http\Controllers\VisaApplicationPackageController;
use App\Http\Controllers\ApplicantContactDetailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrimaryApplicantController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// API Routes for chat history (apply for UK visa)
Route::resource('/visa-application', VisaApplicationController::class);
Route::resource('/visa-application.dependent', VisaDependentController::class);
Route::resource('/visa-application.deadline', VisaDeadlineController::class);
Route::resource('/visa-application.previous-issues', VisaPreviousIssueController::class);
Route::resource('/visa-application.previous-uk-visa', PreviousUkVisaController::class);
Route::resource('/visa-application.sponsor', VisaSponsorController::class);
Route::resource('/visa-application.package', VisaPackageController::class);
Route::resource('/visa-application.message-credits', MessageCreditController::class);
Route::resource('/visa-application.application-package', VisaApplicationPackageController::class);
Route::resource('/visa-application.applicant-contact-details', ApplicantContactDetailController::class);
Route::resource('/visa-application.payment', PaymentController::class);

// API Routes for Journey Planner
Route::resource('/journey-planner.primary-applicant', PrimaryApplicantController::class);

Route::middleware('auth:sanctum')->group(function () {
// API Routes for evisa
Route::resource('/evisa', EvisaController::class);
// API Routes for package
Route::resource('/package', PackageController::class);
// API Routes for template
Route::resource('/template-buying', TemplateBuyingController::class);
// API Routes for visa type
Route::resource('/visa-type', VisaTypeController::class);
});