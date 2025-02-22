<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DeliveryStatusController;
use App\Http\Controllers\Admin\DeliveryTimeController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceModeController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\ShippingModeController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\TypesOfPackingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('frontend.index');
// });

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shipment/{id}/tracking', [HomeController::class, 'showTracking'])->name('shipment.tracking');


require __DIR__.'/auth.php';

Route::macro('CustomResource', function ($url, $controller) {
    Route::controller($controller)->prefix($url)->name($url)->group(function () {
        Route::get('/dataTable', 'dataTable')->name('.dataTable');
    });
    Route::resource($url, $controller);
});

Route::get('/regiter', function () {
    return redirect()->route('login');
});

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard')->middleware('verified', 'user-access:admin');
    Route::controller(ProfileController::class)->prefix('profile')->name('profile')->group(function () {
        Route::get('edit', 'edit')->name('.edit');
        Route::patch('update', 'update')->name('.update');
        Route::delete('destroy', 'destroy')->name('.destroy');
    });
});

Route::middleware('auth', 'verified', 'user-access:admin')->prefix('admin')->group(function () {
    // Route to get senders
    Route::get('/fetch-users', [UserController::class, 'fetchUsers'])->name('fetch.users');
    Route::get('/fetch-user-address/{user_id}', [UserController::class, 'getUserAddress']);
    Route::get('/fetch-recipient/{user_id}', [UserController::class, 'fetchRecipients'])->name('fetch.recipients');
    Route::CustomResource('users', UserController::class);
    Route::CustomResource('roles', RoleController::class);
    Route::CustomResource('delivery-times', DeliveryTimeController::class);
    Route::CustomResource('payment-methods', PaymentMethodController::class);
    Route::CustomResource('shipping-modes', ShippingModeController::class);
    Route::CustomResource('types-of-packings', TypesOfPackingController::class);
    Route::CustomResource('service-modes', ServiceModeController::class);
    Route::CustomResource('delivery-status', DeliveryStatusController::class);
    Route::get('/get-states/{country_id}', [StateController::class, 'getStates'])->name('get.states');
    Route::get('/get-cities/{state_id}', [CityController::class, 'getCities'])->name('get.cities');
    Route::post('/shipments/tracking/{shipment_id}', [ShipmentController::class, 'shipmentsTracking'])->name('shipments.tracking');
    Route::get('/shipments/print', [ShipmentController::class, 'printAll'])->name('shipments.printAll');
    Route::post('/shipments/update-driver', [ShipmentController::class, 'updateDriver'])->name('shipments.updateDriver');
    Route::CustomResource('shipments', ShipmentController::class);
});
