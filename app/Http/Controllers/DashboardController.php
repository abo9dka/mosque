<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceLog;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();

        // الفلتر القادم من الرابط
        $filter = $request->query('filter');

        // استعلام الطلاب الخاص بالمستخدم الحالي
        $query = Student::where('user_id', auth()->id());

        // تطبيق الفلترة
        if (in_array($filter, ['حاضر', 'غائب', 'متأخر'])) {

            $query->whereHas('attendanceLogs', function ($q) use ($today, $filter) {

                $q->where('date', $today)
                    ->where('status', $filter);
            });
        }

        // جلب الطلاب
        $students = $query->get();

        // الإحصائيات
        $presentCount = AttendanceLog::where('date', $today)
            ->where('status', 'حاضر')
            ->count();

        $absentCount = AttendanceLog::where('date', $today)
            ->where('status', 'غائب')
            ->count();

        $lateCount = AttendanceLog::where('date', $today)
            ->where('status', 'متأخر')
            ->count();

        return view('dashboard', compact(
            'students',
            'presentCount',
            'absentCount',
            'lateCount'
        ));
    }
    public function showAttendance()
    {
        $students = Auth::user()->students;

        $today = Carbon::today()->format('Y-m-d');

        return view('attendance', compact('students', 'today'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([

            'attendance' => 'required|array',

            'attendance.*' => 'in:حاضر,غائب,متأخر',

        ]);

        $today = Carbon::today()->format('Y-m-d');

        foreach ($request->attendance as $studentId => $status) {

            AttendanceLog::updateOrCreate(

                [
                    'student_id' => $studentId,

                    'date' => $today

                ],

                [
                    'status' => $status

                ]

            );
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'تم حفظ الحضور بنجاح');
    }
}
