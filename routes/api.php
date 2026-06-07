<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeetingNoteController;
use App\Http\Controllers\Api\MeetingScheduleController;
use App\Http\Controllers\Api\PengumumanController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('auth', AuthController::class);
Route::apiResource('pengumuman', PengumumanController::class);
Route::apiResource('meeting-schedules', MeetingScheduleController::class);
Route::apiResource('meeting-notes', MeetingNoteController::class);
Route::apiResource('attendances', AttendanceController::class);
