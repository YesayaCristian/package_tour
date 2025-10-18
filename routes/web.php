<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

/*
| AUTH ROUTES
*/
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.post');
Route::get('/register', [AuthController::class,'showRegister'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register.post');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

/*
| CUSTOMER ROUTES
| - Semua route customer akan menggunakan middleware block.admin.customer.pages
|   sehingga jika admin sudah login dan mengunjungi halaman ini -> diarahkan ke admin.dashboard
*/

// Halaman publik (guest) tetapi admin tidak boleh mengakses ketika sudah login (middleware block.admin.customer.pages)
Route::middleware(['block.admin.customer.pages'])->group(function () {
    Route::get('/', fn() => view('customer.home'))->name('home');
    Route::get('/packages', [TourPackageController::class,'index'])->name('packages');
    Route::get('/packages/{id}', [TourPackageController::class,'show'])->name('package.detail');
});

// Halaman yang hanya bisa diakses oleh authenticated customer
Route::middleware(['auth','role:customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');
});

/*
| ADMIN ROUTES
| - hanya role admin yang bisa akses
*/
Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // USERS
    Route::resource('users', AdminUserController::class, ['as' => 'admin'])->except(['show']);

    // PACKAGES
    Route::resource('packages', AdminPackageController::class, ['as' => 'admin'])->except(['show']);

    // ORDERS
    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

    // PAYMENTS
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
    Route::post('payments/{id}/status', [AdminPaymentController::class, 'updateStatus'])->name('admin.payments.status');
});