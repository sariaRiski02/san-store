<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AuthenticatedMiddleware;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::group(['middleware' => [AuthenticatedMiddleware::class]], function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::post('/product', [ProductController::class, 'create']);
    Route::get('/product/{id}', [ProductController::class, 'get']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'delete']);
    Route::get('/product', [ProductController::class, 'getAll']);

    Route::get('/sales/check/{code_item}', [SaleController::class, 'check']);
});
