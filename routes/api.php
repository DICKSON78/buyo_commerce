<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\ProductController;

Route::apiResource('users', UserController::class);
Route::apiResource('seller-profiles', SellerProfileController::class);
Route::apiResource('products', ProductController::class);
// Add more resources as needed (e.g., categories, conversations, etc.)
