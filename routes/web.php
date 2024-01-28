<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingCameraController;
use App\Http\Controllers\BookingFacilityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceBrandController;
use App\Http\Controllers\DeviceSeriesController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacilityTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/dashboard');

Route::prefix('auth')->group(function() {
    Route::middleware('guest')->group(function() {
        Route::get('login', [LoginController::class, 'login'])->name('login');
        Route::get('signup', [RegisterController::class, 'signup'])->name('signup');

        Route::post('login', [LoginController::class, 'authenticate'])->name('authenticate');
        Route::post('register', [RegisterController::class, 'createAccount'])->name('register');
    });

    Route::middleware('auth')->group(function() {
        Route::post('logout', LogoutController::class)->name('logout');
    });

});

Route::middleware(['auth'])->group(function() {
    Route::get('dashboard', DashboardController::class)->name("dashboard.index");    
    
    // User
    Route::resource('staff', StaffController::class);
    Route::resource('customers', CustomerController::class);

    // Device
    Route::resource('devices/types', DeviceTypeController::class, ['as' => 'devices']);
    Route::resource('devices/brands', DeviceBrandController::class, ['as' => 'devices']);
    Route::resource('devices/series', DeviceSeriesController::class, ['as' => 'devices']);

    // Product
    Route::resource('products', ProductController::class);

    // Facility
    Route::resource('facilities/types', FacilityTypeController::class, ['as' => 'facilities']);
    Route::resource('facilities/index', FacilityController::class, ['as' => 'facilities']);

    // Transaction
    Route::resource('booking/cameras', BookingCameraController::class, ['as' => 'bookings']);
    Route::resource('booking/facilities', BookingFacilityController::class, ['as' => 'bookings']);

});
Route::fallback(function() {
    return view('errors.404');
});
