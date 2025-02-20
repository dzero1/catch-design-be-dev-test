<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Public Routes */

// API User login
Route::post('/login', [UserAuthController::class,'login']);


/* Protected Routes */
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/logout', [UserAuthController::class,'logout']);


    // Read customer data
    Route::get('/customers', [CustomerController::class, 'index']);
    
    Route::get('/customers/{id}', [CustomerController::class, 'customer']);
});
