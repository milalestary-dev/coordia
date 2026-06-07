<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PengumumanController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('auth', AuthController::class);
Route::apiResource('pengumuman', PengumumanController::class);
