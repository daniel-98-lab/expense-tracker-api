<?php

use App\Infrastructure\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// CATEGORIES
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'getAll']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
