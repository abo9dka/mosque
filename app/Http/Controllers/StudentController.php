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
            'phone_number' => 'nullable',
            'grade' => 'nullable',
            'address' => 'nullable'
        ]);

        Student::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'grade' => $request->grade,
            'address' => $request->address
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
// Validation
        $request->validate([
            'surah' => 'required|string|max:255',
            'from_ayah' => 'required|integer|min:1',
            'to_ayah' => 'required|integer',
            'score' => 'nullable|integer|min:0|max:100',

            'homework' => 'nullable|string|max:255',
            'daily_review' => 'nullable|string|max:255',
            'review_score' => 'nullable|integer|min:0|max:100',
            'review_homework' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

// Store
        ProgressLog::create([
            'student_id' => $id,
            'type' => 'memorization',

            'surah' => $request->surah,
            'from_ayah' => $request->from_ayah,
            'to_ayah' => $request->to_ayah,
            'score' => $request->score,

            'homework' => $request->homework,
            'daily_review' => $request->daily_review,
            'review_score' => $request->review_score,
            'review_homework' => $request->review_homework,
            'notes' => $request->notes,
        ]);

        return back()->with('success', '✅ تم حفظ الحفظ الجديد');

    }

    public function storeReview(Request $request, $id)
    {

// Validation
        $request->validate([
            'weekly_memorization' => 'required|string|max:255',
            'score' => 'nullable|integer|min:0|max:10',
            'review_homework' => 'nullable|string|max:255',
        ]);

// Store
        ProgressLog::create([
            'student_id' => $id,
            'type' => 'big_review',

            'weekly_memorization' => $request->weekly_memorization,
            'score' => $request->score,
            'review_homework' => $request->review_homework,
        ]);

        return back()->with('success', '✅ تم حفظ المراجعة الكبرى');

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

    public function addPoints(Request $request, $id)
    {
// Validate input
        $request->validate([
            'points' => 'required|integer|min:1'
        ]);

// Find student
$student = Student::findOrFail($id);

// Add points (increment)
$student->points += $request->points;
$student->save();

// Redirect back with success message
return redirect()->back()->with('success', 'تمت إضافة النقاط بنجاح');

}

}
