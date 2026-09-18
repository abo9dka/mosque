<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\ProgressLog;
use App\Models\Student;
use App\Models\User;
use App\Support\QuranProgress;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalParents = User::where('role', 'parent')->count();
        $totalStudents = Student::count();
        $studentsWithParent = Student::whereNotNull('parent_id')->count();

        $today = Carbon::today()->toDateString();
        $weekStart = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::FRIDAY);

        $todayAttendance = AttendanceLog::where('date', $today)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $weekAttendance = AttendanceLog::whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $weekMemorizationLogs = ProgressLog::where('type', 'memorization')
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->get();

        $weekLoggedCount = $weekMemorizationLogs->count();
        $weekFailedCount = $weekMemorizationLogs->filter(fn ($log) => $log->isFailed())->count();
        $weekPassedCount = $weekMemorizationLogs->filter(fn ($log) => $log->score !== null && !$log->isFailed())->count();

        $students = Student::with('teacher')->get();

        $completionByStudent = $students->map(function ($student) {
            $progress = QuranProgress::forStudent($student);

            return [
                'student' => $student,
                'percent' => $progress['percent'],
                'memorized' => $progress['memorized'],
            ];
        });

        $avgCompletion = $completionByStudent->isEmpty() ? 0.0 : round($completionByStudent->avg('percent'), 1);

        $topByCompletion = $completionByStudent->sortByDesc('percent')->take(5)->values();

        $topByPoints = $students->sortByDesc('points')->take(5)->values();

        $teacherLoads = User::where('role', 'teacher')
            ->withCount('students')
            ->orderByDesc('students_count')
            ->get();

        return view('admin.dashboard', [
            'totalTeachers' => $totalTeachers,
            'totalParents' => $totalParents,
            'totalStudents' => $totalStudents,
            'studentsWithParent' => $studentsWithParent,
            'todayAttendance' => $todayAttendance,
            'weekAttendance' => $weekAttendance,
            'weekLoggedCount' => $weekLoggedCount,
            'weekPassedCount' => $weekPassedCount,
            'weekFailedCount' => $weekFailedCount,
            'avgCompletion' => $avgCompletion,
            'topByCompletion' => $topByCompletion,
            'topByPoints' => $topByPoints,
            'teacherLoads' => $teacherLoads,
        ]);
    }
}
