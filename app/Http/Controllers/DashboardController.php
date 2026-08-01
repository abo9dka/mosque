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
        if (in_array($filter, [
            AttendanceLog::STATUS_PRESENT,
            AttendanceLog::STATUS_EXCUSED_ABSENCE,
            AttendanceLog::STATUS_UNEXCUSED_ABSENCE,
            AttendanceLog::STATUS_LATE,
        ])) {

            $query->whereHas('attendanceLogs', function ($q) use ($today, $filter) {

                $q->where('date', $today)
                    ->where('status', $filter);
            });
        }

        // جلب الطلاب
        $students = $query->get();

        // الإحصائيات
        $presentCount = AttendanceLog::where('date', $today)
            ->where('status', AttendanceLog::STATUS_PRESENT)
            ->count();

        $absentCount = AttendanceLog::where('date', $today)
            ->whereIn('status', [AttendanceLog::STATUS_EXCUSED_ABSENCE, AttendanceLog::STATUS_UNEXCUSED_ABSENCE])
            ->count();

        $lateCount = AttendanceLog::where('date', $today)
            ->where('status', AttendanceLog::STATUS_LATE)
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

        $today = now()->toDateString();

// جلب حضور اليوم لكل الطلاب
        $attendanceLogs = AttendanceLog::whereDate('date', $today)
            ->get()
            ->keyBy('student_id'); // مهم جدًا

        return view('attendance', compact('students', 'attendanceLogs', 'today'));

    }


    public function storeAttendance(Request $request)
    {
        $request->validate([

            'attendance' => 'required|array',

            'attendance.*' => 'in:' . implode(',', [
                AttendanceLog::STATUS_PRESENT,
                AttendanceLog::STATUS_EXCUSED_ABSENCE,
                AttendanceLog::STATUS_UNEXCUSED_ABSENCE,
                AttendanceLog::STATUS_LATE,
            ]),

            'absence_reason' => 'nullable|array',
            'absence_reason.*' => 'nullable|string|max:255',

        ]);

        $today = Carbon::today()->format('Y-m-d');

        foreach ($request->attendance as $studentId => $status) {

            $reason = $status === AttendanceLog::STATUS_EXCUSED_ABSENCE
                ? $request->input("absence_reason.$studentId")
                : null;

            // خصم/استرجاع النقاط بالفرق بين الحالة القديمة والجديدة حتى لا نخصم مرتين عند إعادة الحفظ
            $existing = AttendanceLog::where('student_id', $studentId)
                ->where('date', $today)
                ->first();

            $oldPenalty = $existing ? AttendanceLog::penaltyFor($existing->status) : 0;
            $newPenalty = AttendanceLog::penaltyFor($status);

            if ($oldPenalty !== $newPenalty) {
                $student = Student::find($studentId);

                if ($student) {
                    $student->points = max(0, $student->points + $oldPenalty - $newPenalty);
                    $student->save();
                }
            }

            AttendanceLog::updateOrCreate(

                [
                    'student_id' => $studentId,

                    'date' => $today

                ],

                [
                    'status' => $status,
                    'absence_reason' => $reason,

                ]

            );
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'تم حفظ الحضور بنجاح');
    }
}
