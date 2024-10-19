<?php

use App\Http\Controllers\Admin\DeliveryTimeController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceModeController;
use App\Http\Controllers\Admin\ShippingModeController;
use App\Http\Controllers\Admin\TypesOfPackingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::macro('CustomResource', function ($url, $controller) {
    Route::controller($controller)->prefix($url)->name($url)->group(function () {
        Route::get('/dataTable', 'dataTable')->name('.dataTable');
    });
    Route::resource($url, $controller);
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
    Route::CustomResource('users', UserController::class);
    Route::CustomResource('roles', RoleController::class);
    Route::CustomResource('delivery-times', DeliveryTimeController::class);
    Route::CustomResource('payment-methods', PaymentMethodController::class);
    Route::CustomResource('shipping-modes', ShippingModeController::class);
    Route::CustomResource('types-of-packings', TypesOfPackingController::class);
    Route::CustomResource('service-modes', ServiceModeController::class);
});
