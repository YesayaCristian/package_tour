<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourPackageController;

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
    Route::get('/cart', fn() => view('customer.cart'))->name('cart');
    Route::get('/checkout', fn() => view('customer.checkout'))->name('checkout');
    Route::get('/orders', fn() => view('customer.orders'))->name('orders');
    Route::get('/payments', fn() => view('customer.payments'))->name('payments');
});

/*
| ADMIN ROUTES
| - hanya role admin yang bisa akses
*/
Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/packages', fn() => view('admin.packages'))->name('admin.packages');
    Route::get('/orders', fn() => view('admin.orders'))->name('admin.orders');
    Route::get('/users', fn() => view('admin.users'))->name('admin.users');
    Route::get('/payments', fn() => view('admin.payments'))->name('admin.payments');
});
