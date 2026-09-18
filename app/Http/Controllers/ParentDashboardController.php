<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\ProgressLog;
use App\Models\ScheduleItem;
use App\Support\QuranProgress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $weekStart = Carbon::now()->startOfWeek(Carbon::SATURDAY)->toDateString();
        $weekEnd = Carbon::now()->endOfWeek(Carbon::FRIDAY)->toDateString();

        $children = Auth::user()->children()->orderBy('name')->get();

        $children->each(function ($student) use ($today, $weekStart, $weekEnd) {
            $student->quran_progress = QuranProgress::forStudent($student);

            $student->today_status = AttendanceLog::where('student_id', $student->id)
                ->where('date', $today)
                ->value('status');

            $student->week_attendance_counts = AttendanceLog::where('student_id', $student->id)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');
        });

        $todayScheduleItems = ScheduleItem::forDay(Carbon::now()->dayOfWeek)->get();

        return view('parent.dashboard', compact('children', 'todayScheduleItems'));
    }

    public function show($id)
    {
        $student = Auth::user()->children()->where('id', $id)->firstOrFail();

        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::FRIDAY);

        $todayLogs = ProgressLog::where('student_id', $student->id)
            ->where('type', 'memorization')
            ->whereDate('created_at', $today)
            ->orderByDesc('created_at')
            ->get();

        $weekLogs = ProgressLog::where('student_id', $student->id)
            ->where('type', 'memorization')
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->orderByDesc('created_at')
            ->get();

        $weekReviewLogs = ProgressLog::where('student_id', $student->id)
            ->where('type', 'big_review')
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->orderByDesc('created_at')
            ->get();

        $weekAttendance = AttendanceLog::where('student_id', $student->id)
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->get()
            ->keyBy('date');

        $weekDays = collect();
        for ($date = $weekStart->copy(); $date->lte($weekEnd); $date->addDay()) {
            $weekDays->push([
                'date' => $date->copy(),
                'log' => $weekAttendance->get($date->toDateString()),
            ]);
        }

        $progress = QuranProgress::forStudent($student);

        return view('parent.student', compact('student', 'todayLogs', 'weekLogs', 'weekReviewLogs', 'weekDays', 'progress'));
    }
}
