<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ServiceRequestController;
use App\Http\Controllers\Frontend\ShowroomController;
use App\Http\Controllers\Frontend\SalesAgentController;
use App\Http\Controllers\Frontend\ServiceEngineerController;

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::post('/record-audio', [HomeController::class, 'recordAudio'])->name('frontend.record-audio');

Route::match(['get', 'post'], '/login', [HomeController::class, 'login'])->name('frontend.login');
Route::get('/logout', [HomeController::class, 'logout'])->name('frontend.logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('frontend.dashboard');
});

Route::group(['middleware' => ['auth', 'showroom_owner']], function () {
    Route::get('/surgical-showroom/service-requests', [ServiceRequestController::class, 'index'])->name('showroom_owner.service_requests');
    Route::get('/surgical-showroom/add-service-request', [ServiceRequestController::class, 'addServiceRequest'])->name('showroom_owner.add-service-request');
    Route::post('/surgical-showroom/create-service-request', [ServiceRequestController::class, 'createServiceRequest'])->name('showroom_owner.create-service-request');
    Route::get('/surgical-showroom/edit-service-request/{id}', [ServiceRequestController::class, 'editServiceRequest'])->name('showroom_owner.edit-service-request');
    Route::post('/surgical-showroom/update-service-request/{id}', [ServiceRequestController::class, 'updateServiceRequest'])->name('showroom_owner.update-service-request');
    Route::get('/surgical-showroom/delete-service-request/{id}', [ServiceRequestController::class, 'deleteServiceRequest'])->name('showroom_owner.delete-service-request');
    Route::get('/surgical-showroom/service-request/tracking-number-details/{requestId}', [ServiceRequestController::class, 'trackingNumberDetails'])->name('showroom_owner.tracking-number-details');
    Route::get('/surgical-showroom/profile-information', [ShowroomController::class, 'profileInformation'])->name('showroom_owner.profile-information');
    Route::get('/surgical-showroom/approve-service-request/{requestId}', [ServiceRequestController::class, 'approveServiceRequest'])->name('showroom_owner.approve-service-request');
    Route::get('/surgical-showroom/disapprove-service-request/{requestId}', [ServiceRequestController::class, 'disapproveServiceRequest'])->name('showroom_owner.disapprove-service-request');
});

Route::group(['middleware' => ['auth', 'sales_agent']], function () {
    Route::get('/sales-agent/service-requests', [SalesAgentController::class, 'index'])->name('sales_agent.service_requests');
    Route::get('/sales-agent/profile-information', [SalesAgentController::class, 'profileInformation'])->name('sales_agent.profile-information');
    Route::get('/sales-agent/service-request/generate-tracking-number/{requestId}', [SalesAgentController::class, 'generateTrackingNumber'])->name('sales_agent.generate-tracking-number');
    Route::post('/sales-agent/service-request/save-tracking-number/{requestId}', [SalesAgentController::class, 'saveTrackingNumber'])->name('sales_agent.save-tracking-number');
    Route::get('/sales-agent/service-request/tracking-number-details/{requestId}', [SalesAgentController::class, 'trackingNumberDetails'])->name('sales_agent.tracking-number-details');
});

Route::group(['middleware' => ['auth', 'service_engineer']], function () {
    Route::get('/service-engineer/service-requests', [ServiceEngineerController::class, 'index'])->name('service_engineer.service_requests');
    Route::get('/service-engineer/profile-information', [ServiceEngineerController::class, 'profileInformation'])->name('service_engineer.profile-information');
    Route::get('/service-engineer/service-request/tracking-number-details/{requestId}', [ServiceEngineerController::class, 'trackingNumberDetails'])->name('service_engineer.tracking-number-details');
    Route::get('/service-engineer/service-request/create-service-report/{requestId}', [ServiceEngineerController::class, 'createServiceReport'])->name('service_engineer.create-service-report');
    Route::post('/service-engineer/service-request/save-service-report/{requestId}', [ServiceEngineerController::class, 'saveServiceReport'])->name('service_engineer.save-service-report');
    Route::get('/service-engineer/service-request/edit-service-report/{requestId}', [ServiceEngineerController::class, 'editServiceReport'])->name('service_engineer.edit-service-report');
    Route::post('/service-engineer/service-request/update-service-report/{requestId}', [ServiceEngineerController::class, 'updateServiceReport'])->name('service_engineer.update-service-report');
    Route::get('/service-engineer/service-request/start-work/{requestId}', [ServiceEngineerController::class, 'startWork'])->name('service_engineer.start-work');
});

?>