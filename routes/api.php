<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('/login', [UserController::class, 'login'])->name("login");

Route::middleware(["auth:sanctum"])->group(function () {
    Route::post('/product', [ProductController::class, 'add']);
    Route::get('/product', [ProductController::class, 'getAll']);
    Route::get('/product/{id}', [ProductController::class, 'getById']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'delete']);
});
