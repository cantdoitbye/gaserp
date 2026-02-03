<?php

use App\Http\Controllers\Admin\AccommodationOfferMasterController;
use App\Http\Controllers\Admin\VisaCountriesController;
use App\Http\Controllers\Admin\VisaTypesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CommercialController;
use App\Http\Controllers\Admin\HolidayBookingsController;
use App\Http\Controllers\Admin\PaymentController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationMasterController;
use App\Http\Controllers\Admin\HadderController;
use App\Http\Controllers\Admin\PeTrackerController;
use App\Http\Controllers\Admin\PngController;
use App\Http\Controllers\Admin\PngMeasurementTypeController;
use App\Http\Controllers\Admin\RiserController;
use App\Http\Controllers\Admin\TourPackageController;
use App\Http\Controllers\Admin\TourQueryController;
use App\Http\Controllers\Admin\RolePermissionsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TourTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisaApplicationController;
use App\Http\Controllers\Admin\UserVisaApplicationController;
use App\Http\Controllers\Api\v1\VisaApplicationController as V1VisaApplicationController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DprController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\LabourController;
use App\Http\Controllers\LegalDashboardController;
use App\Http\Controllers\LegalDocumentTypeController;
use App\Http\Controllers\LegalNotificationController;
use App\Http\Controllers\PePngController;
use App\Http\Controllers\PlumberController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectLegalDocumentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\SubconController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [LoginController::class, 'login'])->name('admin.login');
Route::get('/country', [LoginController::class, 'country']);

Route::group(['prefix' => 'admin'], function () {

Route::post('login/authenticate', [LoginController::class, 'authenticate'])->name('admin.authenticate');
Route::get('verification/{id?}', [LoginController::class, 'verification'])->name('admin.verification');
Route::post('verify-verification-code', [LoginController::class, 'verifyVerificationCode'])->name('admin.verify_verification_code');
Route::get('/resend-verification-code', [LoginController::class, 'resendVerificationCode'])->name('admin.resend_verification_code');

Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('admin.forgot_password');
Route::post('/send-password-reset-link', [ForgotPasswordController::class, 'sendResetPasswordLink'])->name('sadmin.end_password_reset_link');
Route::get('/password/reset/{token?}', [ResetPasswordController::class, 'index'])->name('password_reset');
Route::post('/password/update', [ResetPasswordController::class, 'passwordUpdate'])->name('password_update');


Route::get('/refresh_csrf', function () {
    return response()->json(csrf_token());
});
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'adminPermissions']], function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');

    Route::get('/users/{id}/detail', [UserController::class, 'detail'])->name('admin.user.detail');

    // Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('admin.tours.list');
    // Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('admin.tours.list');
    // Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('admin.tours.list');














Route::get('/roles-permissions', [RolePermissionsController::class, 'rolePermissions'])->name('admin.rolePermissions');
Route::post('/update-permission', [RolePermissionsController::class, 'updatePermission'])->name('admin.updatePermission');

Route::resource('projects', ProjectController::class);
Route::get('/projects/{id}/add-document', [ProjectController::class, 'addDocument'])->name('projects.add-document');


Route::prefix('dpr')->group(function () {
    Route::get('/', [DprController::class, 'index'])->name('dpr.index');
    Route::get('/create', [DprController::class, 'create'])->name('dpr.create');
    Route::post('/store', [DprController::class, 'store'])->name('dpr.store');
    Route::get('/edit/{id}', [DprController::class, 'edit'])->name('dpr.edit');
    Route::put('/update/{id}', [DprController::class, 'update'])->name('dpr.update');
    Route::delete('/destroy/{id}', [DprController::class, 'destroy'])->name('dpr.destroy');
});

// Finance - Taxation Desk Routes
Route::prefix('finance')->group(function () {
    Route::get('/', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/create', [FinanceController::class, 'create'])->name('finance.create');
    Route::post('/store', [FinanceController::class, 'store'])->name('finance.store');
    Route::get('/edit/{id}', [FinanceController::class, 'edit'])->name('finance.edit');
    Route::put('/update/{id}', [FinanceController::class, 'update'])->name('finance.update');
    Route::delete('/destroy/{id}', [FinanceController::class, 'destroy'])->name('finance.destroy');
});

// Legal Dashboard
Route::get('/legal-desk', [LegalDashboardController::class, 'indexdesk'])->name('legal-desk.index');
Route::get('/legal-desk/filter', [LegalDashboardController::class, 'filter'])->name('legal-desk.filter');

Route::get('/projects/{projectId}/legal-desk', [LegalDashboardController::class, 'index'])->name('projects.legal-desk');


Route::post('/panel/service-types/store-ajax', [App\Http\Controllers\ServiceTypeController::class, 'storeAjax'])->name('service-types.store.ajax');


// Legal Document Types
Route::resource('legal-document-types', LegalDocumentTypeController::class);

// Project Legal Documents
Route::resource('project-legal-documents', ProjectLegalDocumentController::class);
Route::post('/project-legal-documents/upload/{id}', [ProjectLegalDocumentController::class, 'uploadDocument'])->name('project-legal-documents.upload');
Route::get('/project-legal-documents/download/{id}', [ProjectLegalDocumentController::class, 'downloadDocument'])->name('project-legal-documents.download');

// Legal Notifications
Route::get('/legal-notifications', [LegalNotificationController::class, 'index'])->name('legal-notifications.index');
Route::post('/legal-notifications/mark-as-read/{id}', [LegalNotificationController::class, 'markAsRead'])->name('legal-notifications.mark-as-read');


Route::prefix('purchase')->group(function () {
    Route::get('/', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/store', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/destroy/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
});

// Sales Desk Routes
Route::prefix('sales')->group(function () {
    Route::get('/', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/store', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/edit/{id}', [SalesController::class, 'edit'])->name('sales.edit');
    Route::put('/update/{id}', [SalesController::class, 'update'])->name('sales.update');
    Route::delete('/destroy/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
});

// Plumber Desk Routes
Route::prefix('plumber')->group(function () {
    Route::get('/', [PlumberController::class, 'index'])->name('plumber.index');
    Route::get('/create', [PlumberController::class, 'create'])->name('plumber.create');
    Route::post('/store', [PlumberController::class, 'store'])->name('plumber.store');
    Route::get('/edit/{id}', [PlumberController::class, 'edit'])->name('plumber.edit');
    Route::put('/update/{id}', [PlumberController::class, 'update'])->name('plumber.update');
    Route::delete('/destroy/{id}', [PlumberController::class, 'destroy'])->name('plumber.destroy');
});

Route::prefix('labour')->group(function () {
    Route::get('/', [LabourController::class, 'index'])->name('labour.index');
    Route::get('/create', [LabourController::class, 'create'])->name('labour.create');
    Route::post('/store', [LabourController::class, 'store'])->name('labour.store');
    Route::get('/edit/{id}', [LabourController::class, 'edit'])->name('labour.edit');
    Route::put('/update/{id}', [LabourController::class, 'update'])->name('labour.update');
    Route::delete('/destroy/{id}', [LabourController::class, 'destroy'])->name('labour.destroy');
});

// Sub Con Desk Routes
Route::prefix('subcon')->group(function () {
    Route::get('/', [SubconController::class, 'index'])->name('subcon.index');
    Route::get('/create', [SubconController::class, 'create'])->name('subcon.create');
    Route::post('/store', [SubconController::class, 'store'])->name('subcon.store');
    Route::get('/edit/{id}', [SubconController::class, 'edit'])->name('subcon.edit');
    Route::put('/update/{id}', [SubconController::class, 'update'])->name('subcon.update');
    Route::delete('/destroy/{id}', [SubconController::class, 'destroy'])->name('subcon.destroy');
});

// Report Routes
Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::post('/download', [ReportController::class, 'download'])->name('reports.download');
});



Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/show/{id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/update/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/destroy/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

// Client Routes
Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/show/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/update/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/destroy/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
});


Route::prefix('profit')->group(function () {
    Route::get('/', [ProfitController::class, 'index'])->name('profit.index');
    Route::get('/analysis', [ProfitController::class, 'analysis'])->name('profit.analysis');
    Route::post('/generate-report', [ProfitController::class, 'generateReport'])->name('profit.generate-report');
});

// Integration Routes
Route::prefix('integrations')->group(function () {
    Route::get('/', [IntegrationController::class, 'index'])->name('integrations.index');
    Route::get('/connect/{provider}', [IntegrationController::class, 'connect'])->name('integrations.connect');
    Route::get('/callback/{provider}', [IntegrationController::class, 'callback'])->name('integrations.callback');
    Route::post('/disconnect/{provider}', [IntegrationController::class, 'disconnect'])->name('integrations.disconnect');
});


Route::get('pe-png/import', [PePngController::class, 'showImportForm'])->name('pe-png.import.form');
Route::post('pe-png/import', [PePngController::class, 'import'])->name('pe-png.import');
Route::get('pe-png/export', [PePngController::class, 'export'])->name('pe-png.export');
Route::resource('pe-png', PePngController::class);
Route::delete('png/bulk-delete', [PngController::class, 'bulkDelete'])->name('png.bulk-delete');

  // PNG Routes
    Route::resource('png', PngController::class);
    Route::post('png/search', [PngController::class, 'index'])->name('png.search');
    Route::post('png/update-plumber', [PngController::class, 'updatePlumber'])->name('png.update-plumber');
    Route::post('png/import-plumber-data', [PngController::class, 'importPlumberData'])->name('png.import-plumber-data');
    
    // PNG Import/Export Routes
    Route::get('png-import', [PngController::class, 'showImportForm'])->name('png.import.form');
    Route::post('png-import', [PngController::class, 'import'])->name('png.import');
    Route::get('png-export', [PngController::class, 'export'])->name('png.export');
    
    Route::get('png/stats', [PngController::class, 'getStats'])->name('png.stats');

        // AJAX routes for PNG
    Route::get('png/measurement-types/by-png-type', [PngController::class, 'getMeasurementTypesByPngType'])->name('png.measurement-types.by-png-type');
    Route::get('png/measurement-fields', [PngController::class, 'getMeasurementFields'])->name('png.measurement-fields');
    
        Route::get('download-template', [PngController::class, 'downloadTemplate'])->name('png.download-template'); // NEW

    // PNG Measurement Types Management
    Route::resource('png-measurement-types', PngMeasurementTypeController::class);
    Route::post('png-measurement-types/create-defaults', [PngMeasurementTypeController::class, 'createDefaults'])->name('png-measurement-types.create-defaults');
    Route::patch('png-measurement-types/{pngMeasurementType}/toggle-status', [PngMeasurementTypeController::class, 'toggleStatus'])->name('png-measurement-types.toggle-status');
    
    // AJAX routes for measurement types
    Route::get('/png-measurement-type/get-by-png-type', [PngMeasurementTypeController::class, 'getByPngType'])->name('png-measurement-types.get-by-png-type');
    Route::get('png-measurement-types/{pngMeasurementType}/fields', [PngMeasurementTypeController::class, 'getMeasurementFields'])->name('png-measurement-types.get-fields');


      Route::prefix('commercial')->name('commercial.')->group(function () {
        Route::get('/', [CommercialController::class, 'index'])->name('index');
        Route::get('create', [CommercialController::class, 'create'])->name('create');
        Route::post('/', [CommercialController::class, 'store'])->name('store');
        Route::get('{commercial}', [CommercialController::class, 'show'])->name('show');
        Route::get('{commercial}/edit', [CommercialController::class, 'edit'])->name('edit');
        Route::put('{commercial}', [CommercialController::class, 'update'])->name('update');
        Route::delete('{commercial}', [CommercialController::class, 'destroy'])->name('destroy');
        
        // Import & Export
        Route::get('import/form', [CommercialController::class, 'showImportForm'])->name('import.form');
        Route::post('import', [CommercialController::class, 'import'])->name('import');
        Route::get('export', [CommercialController::class, 'export'])->name('export');
        
        // AJAX Routes
        Route::get('stats', [CommercialController::class, 'getStats'])->name('stats');
        Route::get('measurement-types/by-type', [CommercialController::class, 'getMeasurementTypesByCommercialType'])->name('measurement-types.by-type');
        Route::get('measurement-fields/{measurement_type_id}', [CommercialController::class, 'getMeasurementFields'])->name('measurement-fields');
    });

    // Riser Module Routes
    Route::prefix('riser')->name('riser.')->group(function () {
        Route::get('/', [RiserController::class, 'index'])->name('index');
        Route::get('create', [RiserController::class, 'create'])->name('create');
        Route::post('/', [RiserController::class, 'store'])->name('store');
        Route::get('{riser}', [RiserController::class, 'show'])->name('show');
        Route::get('{riser}/edit', [RiserController::class, 'edit'])->name('edit');
        Route::put('{riser}', [RiserController::class, 'update'])->name('update');
        Route::delete('{riser}', [RiserController::class, 'destroy'])->name('destroy');
        
        // Import & Export
        Route::get('import/form', [RiserController::class, 'showImportForm'])->name('import.form');
        Route::post('import', [RiserController::class, 'import'])->name('import');
        Route::get('export', [RiserController::class, 'export'])->name('export');
        
        // AJAX Routes
        Route::get('stats', [RiserController::class, 'getStats'])->name('stats');
        Route::get('measurement-types/by-type', [RiserController::class, 'getMeasurementTypesByRiserType'])->name('measurement-types.by-type');
        Route::get('measurement-fields/{measurement_type_id}', [RiserController::class, 'getMeasurementFields'])->name('measurement-fields');
    });

    // Ladder Module Routes
    Route::prefix('ladder')->name('ladder.')->group(function () {
        Route::get('/', [HadderController::class, 'index'])->name('index');
        Route::get('create', [HadderController::class, 'create'])->name('create');
        Route::post('/', [HadderController::class, 'store'])->name('store');
        Route::get('{ladder}', [HadderController::class, 'show'])->name('show');
        Route::get('{ladder}/edit', [HadderController::class, 'edit'])->name('edit');
        Route::put('{ladder}', [HadderController::class, 'update'])->name('update');
        Route::delete('{ladder}', [HadderController::class, 'destroy'])->name('destroy');
        
        // Import & Export
        Route::get('import/form', [HadderController::class, 'showImportForm'])->name('import.form');
        Route::post('import', [HadderController::class, 'import'])->name('import');
        Route::get('export', [HadderController::class, 'export'])->name('export');
        
        // AJAX Routes
        Route::get('stats', [HadderController::class, 'getStats'])->name('stats');
        Route::get('measurement-types/by-type', [HadderController::class, 'getMeasurementTypesByLadderType'])->name('measurement-types.by-type');
        Route::get('measurement-fields/{measurement_type_id}', [HadderController::class, 'getMeasurementFields'])->name('measurement-fields');
    });

     // PE Tracker Routes
    Route::resource('pe-tracker', PeTrackerController::class);
    
    // Import/Export Routes
    Route::get('pe-tracker-import', [PeTrackerController::class, 'showImportForm'])->name('pe-tracker.import.form');
    Route::post('pe-tracker-import', [PeTrackerController::class, 'import'])->name('pe-tracker.import');
    Route::get('pe-tracker-export', [PeTrackerController::class, 'export'])->name('pe-tracker.export');
    
    Route::get('/test-png', function() {
    try {
        $data = ['name' => 'Test PNG Job'];
        $png = \App\Models\Png::create($data);
        
        if ($png) {
            return "✓ PNG created with ID: " . $png->id;
        } else {
            return "✗ PNG creation returned null/false";
        }
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});


Route::resource('plumbers', PlumberController::class);


Route::resource('service-types', ServiceTypeController::class);

// routes/web.php
Route::get('/purchase-assets', function () {
    return view('panel.purchase-asset.index');
})->name('purchase-assets.index');

Route::get('/sales-financial', function () {
    return view('panel.sales-financial.index');
})->name('sales-financial.index');


Route::get('/consumption', function () {
    return view('panel.consumption.index');
})->name('consumption.index');


});





// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
