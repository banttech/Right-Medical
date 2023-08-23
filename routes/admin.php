<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShowroomController;
use App\Http\Controllers\Admin\ServiceEngineerController;
use App\Http\Controllers\Admin\SalesAgentController;
use App\Http\Controllers\Admin\ServiceRequestController;


Route::get('admin/login', [LoginController::class, 'index'])->name('super_admin.login');
Route::post('admin/signin', [LoginController::class, 'signin'])->name('super_admin.signin');
Route::group(['prefix' => 'admin', 'middleware' => ['super_admin']], function () {
    Route::get('/', [LoginController::class, 'index'])->name('super_admin.login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('super_admin.logout');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('super_admin.dashboard');
    Route::get('/manage-profile', [DashboardController::class, 'manageProfile'])->name('super_admin.manage_profile');
    Route::post('/update-profile', [DashboardController::class, 'updateProfile'])->name('super_admin.update_profile');
    Route::get('/surgical-showrooms', [ShowroomController::class, 'index'])->name('super_admin.surgical_showrooms');
    Route::get('/add-surgical-showroom', [ShowroomController::class, 'addShowroom'])->name('super_admin.add_surgical_showroom');
    Route::post('/create-showroom', [ShowroomController::class, 'createShowroom'])->name('super_admin.create_showroom');
    Route::get('/edit-surgical-showroom/{id}', [ShowroomController::class, 'editShowroom'])->name('super_admin.edit_surgical_showroom');
    Route::post('/update-showroom/{id}', [ShowroomController::class, 'updateShowroom'])->name('super_admin.update_showroom');
    Route::get('/delete-surgical-showroom/{id}', [ShowroomController::class, 'deleteShowroom'])->name('super_admin.delete_surgical_showroom');
    // service engineer routes
    Route::get('/service-engineers', [ServiceEngineerController::class, 'index'])->name('super_admin.service_engineers');
    Route::get('/add-service-engineer', [ServiceEngineerController::class, 'addServiceEngineer'])->name('super_admin.add_service_engineer');
    Route::post('/create-service-engineer', [ServiceEngineerController::class, 'createServiceEngineer'])->name('super_admin.create_service_engineer');
    Route::get('/edit-service-engineer/{id}', [ServiceEngineerController::class, 'editServiceEngineer'])->name('super_admin.edit_service_engineer');
    Route::post('/update-service-engineer/{id}', [ServiceEngineerController::class, 'updateServiceEngineer'])->name('super_admin.update_service_engineer');
    Route::get('/delete-service-engineer/{id}', [ServiceEngineerController::class, 'deleteServiceEngineer'])->name('super_admin.delete_service_engineer');
    // sales agent routes
    Route::get('/sales-agents', [SalesAgentController::class, 'index'])->name('super_admin.sales_agents');
    Route::get('/add-sales-agent', [SalesAgentController::class, 'addSalesAgent'])->name('super_admin.add_sales_agent');
    Route::post('/create-sales-agent', [SalesAgentController::class, 'createSalesAgent'])->name('super_admin.create_sales_agent');
    Route::get('/edit-sales-agent/{id}', [SalesAgentController::class, 'editSalesAgent'])->name('super_admin.edit_sales_agent');
    Route::post('/update-sales-agent/{id}', [SalesAgentController::class, 'updateSalesAgent'])->name('super_admin.update_sales_agent');
    Route::get('/delete-sales-agent/{id}', [SalesAgentController::class, 'deleteSalesAgent'])->name('super_admin.delete_sales_agent');
    // service request routes
    Route::get('/service-requests', [ServiceRequestController::class, 'index'])->name('super_admin.service_requests');
    Route::get('/service-request/assign-agent/{requestId}', [ServiceRequestController::class, 'assignAgent'])->name('super_admin.assign_agent');
    Route::post('/service-request/allocate-to-sales-agent/{requestId}', [ServiceRequestController::class, 'allocateToSalesAgent'])->name('super_admin.allocate_to_sales_agent');
    Route::get('/service-request/assign-engineer/{requestId}', [ServiceRequestController::class, 'assignEngineer'])->name('super_admin.assign_engineer');
    Route::post('/service-request/allocate-to-service-engineer/{requestId}', [ServiceRequestController::class, 'allocateToServiceEngineer'])->name('super_admin.allocate_to_service_engineer');
    Route::get('/service-request/save-tracking-number/{requestId}', [ServiceRequestController::class, 'saveTrackingNumber'])->name('super_admin.save_tracking_number');
    Route::get('/service-request/tracking-number-details/{requestId}', [ServiceRequestController::class, 'trackingNumberDetails'])->name('super_admin.tracking_number_details');
    // serivice engineer report
    Route::get('/service-request/service-engineer-report/{requestId}', [ServiceRequestController::class, 'serviceEngineerReport'])->name('super_admin.service_engineer_report');
    Route::post('/service-request/update-service-request/{requestId}', [ServiceRequestController::class, 'updateServiceRequest'])->name('super_admin.update_service_request');
    // Service Request Status
    Route::post('/service-request/change-device-receiving-status', [ServiceRequestController::class, 'changeDeviceReceivingStatus'])->name('super_admin.change_device_receiving_status');
});

?>