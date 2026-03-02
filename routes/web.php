<?php

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class,'showLogin']);
Route::post('/login', [AuthController::class,'login']);

Route::get('/register', [AuthController::class,'showRegister']);
Route::post('/register', [AuthController::class,'register']);

Route::get('/admin/dashboard', [AuthController::class,'adminDashboard'])->middleware('auth');
Route::get('/user/dashboard', [AuthController::class,'userDashboard'])->middleware('auth');

Route::post('/logout', [AuthController::class,'logout']);