<?php

namespace App\Http\Controllers;

use App\Models\ProgressLog;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function create()
    {
        return view('create-student');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'nullable'
        ]);

        Student::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone_number' => $request->phone_number
        ]);

        return redirect()->route('dashboard');
    }
    public function follow($id)
    {
        $student = Student::findOrFail($id);

        $progress = ProgressLog::where('student_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('follow', compact('student', 'progress'));
    }
    public function storeFollow(Request $request, $id)
    {
        ProgressLog::create([
            'part_number' => $request->part_number,
            'student_id' => $id,
            'surah_name' => $request->surah,
            'from_ayah' => $request->from_ayah,
            'to_ayah' => $request->to_ayah,
            'ayah_count' => $request->ayah_count,
            'score' => $request->score,
        ]);

        return back()->with('success', 'تم الحفظ');
    }
    public function showProgress($id)
    {
        $student = Student::findOrFail($id);

        $progress = ProgressLog::where('student_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student-progress', compact('student', 'progress'));
    }
    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return view('edite-student', compact('student'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'nullable'
        ]);

        $student = Student::findOrFail($id);
        $student->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);
        return redirect()->route('dashboard');
    }
    public function delete($id)
    {
        Student::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->back();
    }
}
