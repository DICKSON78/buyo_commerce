<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\CustomerController;


// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/join', [AuthController::class, 'choose'])->name('choose');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/checkout',[CheckoutController::class,'checkout'])->name('products.checkout');

Route::prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerProfileController::class, 'index'])->name('seller.dashboard');
});

Route::prefix('customer')->group(function(){
    Route::get('/dashboard',[CustomerController::class ,'index'])->name('customer.dashboard');
});
