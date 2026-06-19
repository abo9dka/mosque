<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// مسارات الضيوف (الأساتذة غير مسجلي الدخول)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// مسارات محمية (للطاقم المسجل دخوله فقط)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/attendance', [DashboardController::class, 'showAttendance'])
        ->name('attendance');

    Route::post('/attendance/store', [DashboardController::class, 'storeAttendance'])
        ->name('attendance.store');
    Route::get('/student/create', [StudentController::class, 'create'])
        ->name('student.create');

    Route::post('/student/store', [StudentController::class, 'store'])
        ->name('student.store');
    Route::post(
        '/student/{id}/follow',
        [StudentController::class, 'storeFollow']
    )
        ->name('student.follow.store');
    Route::get(
        '/student/{id}/progress',
        [StudentController::class, 'showProgress']
    )
        ->name('student.progress');
    Route::get('/student/{id}/follow', [StudentController::class, 'follow'])->name('student.follow');

    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');

    Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');

    Route::delete('/student/{id}', [StudentController::class, 'delete'])->name('student.delete');
});
