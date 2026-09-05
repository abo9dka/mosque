<?php

namespace App\Http\Controllers;

use App\Models\ProgressLog;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function create()
    {
        $parents = User::where('role', 'parent')->orderBy('name')->get(['id', 'name', 'phone']);

        return view('create-student', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateStudent($request);

        Student::create([
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'],
            'name' => $validated['name'],
            'grade' => $validated['grade'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('dashboard');
    }

    private function validateStudent(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'parent_id' => 'required|integer|exists:users,id',
            'grade' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->filled('parent_id')) {
                $parent = User::find($request->parent_id);

                if (!$parent || $parent->role !== 'parent') {
                    $validator->errors()->add('parent_id', 'الرجاء اختيار ولي أمر صحيح من القائمة.');
                }
            }
        });

        return $validator->validate();
    }
    public function follow($id)
    {
        $student = Student::findOrFail($id);

        $progress = ProgressLog::where('student_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $surahs = config('quran.surahs');

        return view('follow', compact('student', 'progress', 'surahs'));
    }
    public function storeFollow(Request $request, $id)
    {
        $surahs = collect(config('quran.surahs'));

// Validation
        $validator = Validator::make($request->all(), [
            'surah' => ['required', 'string', 'max:255', Rule::in($surahs->pluck('name'))],
            'surah_number' => 'required|integer|between:1,114',
            'from_ayah' => 'required|integer|min:1',
            'to_ayah' => 'required|integer|gte:from_ayah',
            'score' => 'nullable|integer|min:0|max:100',

            'homework' => 'nullable|string|max:255',
            'daily_review' => 'nullable|string|max:255',
            'review_score' => 'nullable|integer|min:0|max:100',
            'review_homework' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validator->after(function ($validator) use ($request, $surahs) {
            $surah = $surahs->firstWhere('number', (int) $request->surah_number);

            if (!$surah) {
                $validator->errors()->add('surah', 'السورة المختارة غير صحيحة.');
                return;
            }

            if ($surah['name'] !== $request->surah) {
                $validator->errors()->add('surah', 'السورة المختارة غير صحيحة.');
                return;
            }

            if ($request->filled('to_ayah') && (int) $request->to_ayah > $surah['ayahs']) {
                $validator->errors()->add('to_ayah', "سورة {$surah['name']} تحتوي على {$surah['ayahs']} آية فقط.");
            }

            if ($request->filled('from_ayah') && (int) $request->from_ayah > $surah['ayahs']) {
                $validator->errors()->add('from_ayah', "سورة {$surah['name']} تحتوي على {$surah['ayahs']} آية فقط.");
            }
        });

        $validated = $validator->validate();

// Store
        ProgressLog::create([
            'student_id' => $id,
            'type' => 'memorization',

            'surah' => $validated['surah'],
            'surah_number' => $validated['surah_number'],
            'from_ayah' => $validated['from_ayah'],
            'to_ayah' => $validated['to_ayah'],
            'score' => $validated['score'] ?? null,

            'homework' => $validated['homework'] ?? null,
            'daily_review' => $validated['daily_review'] ?? null,
            'review_score' => $validated['review_score'] ?? null,
            'review_homework' => $validated['review_homework'] ?? null,
            'notes' => $validated['notes'] ?? null,
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
        $parents = User::where('role', 'parent')->orderBy('name')->get(['id', 'name', 'phone']);

        return view('edite-student', compact('student', 'parents'));
    }
    public function update(Request $request, $id)
    {
        $validated = $this->validateStudent($request);

        $student = Student::findOrFail($id);
        $student->update([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'],
            'grade' => $validated['grade'] ?? null,
            'address' => $validated['address'] ?? null,
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

    public function subtractPoints(Request $request, $id)
    {
// Validate input
        $request->validate([
            'points' => 'required|integer|min:1'
        ]);

// Find student
$student = Student::findOrFail($id);

// Subtract points (never go below zero)
$student->points = max(0, $student->points - $request->points);
$student->save();

// Redirect back with success message
return redirect()->back()->with('success', 'تم خصم النقاط بنجاح');

}

}
