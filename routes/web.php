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
use App\Http\Controllers\FacilityCartController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacilityTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
    
    Route::middleware(['auth', 'verified'])->group(function() {
        Route::post('logout', LogoutController::class)->name('logout');
    });
    
});
Route::get('/email/verify', function () {
    return view("auth.verify-email");
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function() {
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
    Route::get('products/{product}/json', [ProductController::class, 'showJson']);

    // Facility
    Route::resource('facilities/types', FacilityTypeController::class, ['as' => 'facilities']);
    Route::resource('facilities/index', FacilityController::class, ['as' => 'facilities']);
    Route::get('facilities/{facility}/json', [FacilityController::class, 'showJson']);
    
    // Cart
    Route::resource('carts/products', ProductCartController::class, ['as' => 'carts']);
    Route::put('carts/products/{product}/change-booking-date', [ProductCartController::class, 'changeBookingDate']);

    Route::resource('carts/facilities', FacilityCartController::class, ['as' => 'carts']);
    Route::put('carts/facilities/{facility}/change-booking-date', [FacilityCartController::class, 'changeBookingDate']);

    // Transaction
    Route::resource('booking/cameras', BookingCameraController::class, ['as' => 'bookings']);
    Route::resource('booking/facilities', BookingFacilityController::class, ['as' => 'bookings']);

    Route::get("/orders", [OrderController::class, "index"])->name("orders.index");
    Route::get("/orders/camera/{order}", [OrderController::class, "showCamera"])->name("orders.camera.show");
    Route::get("/orders/facility/{order}", [OrderController::class, "showFacility"])->name("orders.facility.show");
    Route::delete("/orders/camera/{order}", [OrderController::class, "destroyCamera"])->name("orders.camera.destroy");
    Route::delete("/orders/facility/{order}", [OrderController::class, "destroyFacility"])->name("orders.facility.destroy");

});
Route::fallback(function() {
    return view('errors.404');
});
