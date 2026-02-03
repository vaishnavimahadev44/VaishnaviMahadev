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
use App\Http\Controllers\EligibilityInfoController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\EmploymentInfoController;
use App\Http\Controllers\TravelInfoController;
use App\Http\Controllers\AdditionalApplicantController;
use App\Http\Controllers\AdditionalEmploymentInfoController;
use App\Http\Controllers\AdditionalTravelInfoController;
use App\Http\Controllers\VisaDocumentController;
use App\Http\Controllers\VisaDocumentFileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CustomerResponseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerUploadDocumentController;

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
Route::resource('/journey-planner.eligibility-info', EligibilityInfoController::class);
Route::resource('/journey-planner.personal-info', controller: PersonalInfoController::class);
Route::resource('/journey-planner.employment-info', controller: EmploymentInfoController::class);
Route::resource('/journey-planner.travel-info', controller: TravelInfoController::class);
Route::resource('/journey-planner.additional-applicant', controller: AdditionalApplicantController::class);
Route::resource('/journey-planner.additional-employment-info', controller:AdditionalEmploymentInfoController::class);
Route::resource('/journey-planner.additional-travel-info', controller:AdditionalTravelInfoController::class);
Route::resource('/journey-planner.visa-document', controller:VisaDocumentController::class);
Route::resource('/journey-planner.visa-document-file', controller:VisaDocumentFileController::class);

//API Routes for buy templates and Packages
Route::post('/templates-and-packages/generate-session', [SessionController::class, 'generateSession']);
Route::resource('/templates-and-packages.customer-response', controller:CustomerResponseController::class);
Route::resource('/templates-and-packages.customer', controller:CustomerController::class);
Route::resource('/templates-and-packages.customer-order', controller:CustomerOrderController::class);
Route::resource('/templates-and-packages.customer-document', controller:CustomerUploadDocumentController::class);


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