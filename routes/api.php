<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('/user', [UserController::class, 'login']);
Route::post('/product', [ProductController::class, 'add'])->middleware("auth:sanctum");
