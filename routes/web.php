<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParentAccountController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherAccountController;
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

// مسارات المدير
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // الإحصائيات
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // إدارة حسابات أولياء الأمور
    Route::get('/parents', [ParentAccountController::class, 'index'])->name('parents.index');
    Route::get('/parents/create', [ParentAccountController::class, 'create'])->name('parents.create');
    Route::post('/parents', [ParentAccountController::class, 'store'])->name('parents.store');
    Route::get('/parents/{id}/edit', [ParentAccountController::class, 'edit'])->name('parents.edit');
    Route::put('/parents/{id}', [ParentAccountController::class, 'update'])->name('parents.update');
    Route::delete('/parents/{id}', [ParentAccountController::class, 'destroy'])->name('parents.destroy');

    // إدارة حسابات الأساتذة ونقل الطلاب بينهم
    Route::get('/teachers', [TeacherAccountController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherAccountController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherAccountController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{id}', [TeacherAccountController::class, 'show'])->name('teachers.show');
    Route::get('/teachers/{id}/edit', [TeacherAccountController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{id}', [TeacherAccountController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherAccountController::class, 'destroy'])->name('teachers.destroy');
    Route::post('/teachers/{id}/transfer-students', [TeacherAccountController::class, 'transferStudents'])->name('teachers.transferStudents');

    // إدارة نشاطات المسجد
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');

    // الجدول الأسبوعي
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/{day}', [ScheduleController::class, 'show'])->where('day', '[0-6]')->name('schedule.show');
    Route::post('/schedule/{day}/items', [ScheduleController::class, 'store'])->where('day', '[0-6]')->name('schedule.items.store');
    Route::put('/schedule/items/{id}', [ScheduleController::class, 'update'])->name('schedule.items.update');
    Route::delete('/schedule/items/{id}', [ScheduleController::class, 'destroy'])->name('schedule.items.destroy');
    Route::post('/schedule/items/{id}/move', [ScheduleController::class, 'move'])->name('schedule.items.move');
});

// مسارات أولياء الأمور
Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/student/{id}', [ParentDashboardController::class, 'show'])->name('student.show');
});
