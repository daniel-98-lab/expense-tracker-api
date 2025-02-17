<?php

use App\Infrastructure\Http\Controllers\AuthController;
use App\Infrastructure\Http\Controllers\CategoryController;
use App\Infrastructure\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    // CATEGORIES
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::get('/categories', [CategoryController::class, 'getAll']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);

    // USERS
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/tokens/refresh', [AuthController::class, 'refreshToken'])->name('auth.refresh');
});

Route::post('/login', [AuthController::class, 'login']);