<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherAccountController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->withCount('students')
            ->orderBy('name')
            ->get();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users,phone',
            'password' => 'required|string|min:4',
        ]);

        User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
        ]);

        return redirect()->route('admin.teachers.index')->with('success', '✅ تم إنشاء حساب الأستاذ بنجاح');
    }

    public function show($id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);
        $students = $teacher->students()->orderBy('name')->get();
        $otherTeachers = User::where('role', 'teacher')->where('id', '!=', $id)->orderBy('name')->get(['id', 'name', 'phone']);

        return view('admin.teachers.show', compact('teacher', 'students', 'otherTeachers'));
    }

    public function edit($id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:255', Rule::unique('users', 'phone')->ignore($teacher->id)],
            'password' => 'nullable|string|min:4',
        ]);

        $teacher->name = $validated['name'];
        $teacher->phone = $validated['phone'];

        if (!empty($validated['password'])) {
            $teacher->password = Hash::make($validated['password']);
        }

        $teacher->save();

        return redirect()->route('admin.teachers.index')->with('success', '✅ تم تحديث بيانات الأستاذ');
    }

    public function destroy($id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        if ($teacher->students()->exists()) {
            return back()->with('error', 'لا يمكن حذف هذا الأستاذ لأنه يملك طلابًا مسجلين. الرجاء نقل الطلاب إلى أستاذ آخر أولاً.');
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')->with('success', '🗑️ تم حذف حساب الأستاذ');
    }

    public function transferStudents(Request $request, $id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'integer',
            'to_teacher_id' => 'required|integer',
        ]);

        $toTeacher = User::where('role', 'teacher')->find($validated['to_teacher_id']);

        if (!$toTeacher || $toTeacher->id === $teacher->id) {
            return back()->with('error', 'الرجاء اختيار أستاذ آخر صحيح لنقل الطلاب إليه.');
        }

        $validStudentIds = Student::where('user_id', $teacher->id)
            ->whereIn('id', $validated['student_ids'])
            ->pluck('id');

        if ($validStudentIds->isEmpty()) {
            return back()->with('error', 'لم يتم تحديد أي طالب صحيح للنقل.');
        }

        DB::transaction(function () use ($validStudentIds, $toTeacher) {
            Student::whereIn('id', $validStudentIds)->update(['user_id' => $toTeacher->id]);
        });

        $count = $validStudentIds->count();

        return redirect()->route('admin.teachers.show', $teacher->id)
            ->with('success', "✅ تم نقل {$count} " . ($count === 1 ? 'طالب' : 'طلاب') . " إلى {$toTeacher->name}");
    }
}
