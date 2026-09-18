<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Support\ArabicDate;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::orderByDesc('date')->orderByDesc('id')->get();

        $activities->each(function ($activity) {
            $activity->dateLabel = ArabicDate::label($activity->date);
        });

        $totalActivities = $activities->count();
        $totalParticipations = $activities->sum('students_count');

        $thisMonthCount = $activities->filter(function ($activity) {
            return $activity->date->isSameMonth(now()) && $activity->date->isSameYear(now());
        })->count();

        return view('admin.activities.index', compact('activities', 'totalActivities', 'totalParticipations', 'thisMonthCount'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'date' => 'required|date',
            'students_count' => 'required|integer|min:0',
        ]);

        Activity::create($validated);

        return redirect()->route('admin.activities.index')->with('success', '✅ تم إضافة النشاط بنجاح');
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);

        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'date' => 'required|date',
            'students_count' => 'required|integer|min:0',
        ]);

        $activity->update($validated);

        return redirect()->route('admin.activities.index')->with('success', '✅ تم تحديث بيانات النشاط');
    }

    public function destroy($id)
    {
        Activity::where('id', $id)->delete();

        return redirect()->route('admin.activities.index')->with('success', '🗑️ تم حذف النشاط');
    }
}
