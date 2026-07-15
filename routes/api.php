<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataApiController;
use App\Http\Controllers\Api\StudentApiController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Students
    Route::get('/students', [StudentApiController::class, 'index']);
    Route::get('/students/{student}', [StudentApiController::class, 'show']);

    // Classrooms
    Route::get('/classrooms', [DataApiController::class, 'classrooms']);

    // Grades
    Route::get('/grades/{student}', [DataApiController::class, 'grades']);
    Route::post('/grades', [DataApiController::class, 'storeGrade']);

    // Attendances
    Route::get('/attendances/{student}', [DataApiController::class, 'attendances']);
    Route::post('/attendances', [DataApiController::class, 'storeAttendance']);

    // Payments
    Route::get('/payments/{student}', [DataApiController::class, 'payments']);

    // Announcements
    Route::get('/announcements', [DataApiController::class, 'announcements']);

    // Timetable
    Route::get('/timetable', [DataApiController::class, 'timetable']);

    // Notifications
    Route::get('/notifications', [DataApiController::class, 'notifications']);
    Route::post('/notifications/{id}/read', [DataApiController::class, 'markNotificationRead']);
});
