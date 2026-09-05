<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// مسارات الضيوف (غير مسجلي الدخول)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// تسجيل الخروج (متاح لأي مستخدم مسجل دخوله، بغض النظر عن دوره)
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// مسارات الأساتذة
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    Route::post(
        '/student/{id}/review',
        [StudentController::class, 'storeReview']
    )
        ->name('student.review.store');
    Route::post(
        '/student/{id}/addpoints',
        [StudentController::class, 'addPoints']
    )
        ->name('students.addPoints');
    Route::post(
        '/student/{id}/subtractpoints',
        [StudentController::class, 'subtractPoints']
    )
        ->name('students.subtractPoints');

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

// مسارات المدير (إدارة حسابات أولياء الأمور)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/parents', [AdminController::class, 'index'])->name('parents.index');
    Route::get('/parents/create', [AdminController::class, 'create'])->name('parents.create');
    Route::post('/parents', [AdminController::class, 'store'])->name('parents.store');
    Route::get('/parents/{id}/edit', [AdminController::class, 'edit'])->name('parents.edit');
    Route::put('/parents/{id}', [AdminController::class, 'update'])->name('parents.update');
    Route::delete('/parents/{id}', [AdminController::class, 'destroy'])->name('parents.destroy');
});

// مسارات أولياء الأمور
Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/student/{id}', [ParentDashboardController::class, 'show'])->name('student.show');
});
