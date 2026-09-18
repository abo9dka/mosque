<?php

namespace App\Http\Controllers;

use App\Models\ScheduleItem;
use App\Support\ArabicDate;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $counts = ScheduleItem::selectRaw('day_of_week, count(*) as total')
            ->groupBy('day_of_week')
            ->pluck('total', 'day_of_week');

        // نعرض الأيام بترتيب السبت → الجمعة المعتمد في بقية التطبيق
        $orderedDays = [6, 0, 1, 2, 3, 4, 5];

        $days = collect($orderedDays)->map(fn ($day) => [
            'day' => $day,
            'name' => ArabicDate::dayName($day),
            'count' => $counts->get($day, 0),
        ]);

        return view('admin.schedule.index', compact('days'));
    }

    public function show($day)
    {
        $day = (int) $day;
        abort_unless($day >= 0 && $day <= 6, 404);

        $dayName = ArabicDate::dayName($day);
        $items = ScheduleItem::forDay($day)->get();

        return view('admin.schedule.show', compact('day', 'dayName', 'items'));
    }

    public function store(Request $request, $day)
    {
        $day = (int) $day;
        abort_unless($day >= 0 && $day <= 6, 404);

        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $nextOrder = (int) ScheduleItem::where('day_of_week', $day)->max('sort_order') + 1;

        ScheduleItem::create([
            'day_of_week' => $day,
            'content' => $validated['content'],
            'sort_order' => $nextOrder,
        ]);

        return back()->with('success', '✅ تمت إضافة القسم إلى برنامج اليوم');
    }

    public function update(Request $request, $id)
    {
        $item = ScheduleItem::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $item->update(['content' => $validated['content']]);

        return back()->with('success', '✅ تم تحديث القسم');
    }

    public function destroy($id)
    {
        $item = ScheduleItem::findOrFail($id);
        $item->delete();

        return back()->with('success', '🗑️ تم حذف القسم');
    }

    public function move(Request $request, $id)
    {
        $validated = $request->validate([
            'direction' => 'required|in:up,down',
        ]);

        $item = ScheduleItem::findOrFail($id);

        $neighbor = $validated['direction'] === 'up'
            ? ScheduleItem::where('day_of_week', $item->day_of_week)
                ->where('sort_order', '<', $item->sort_order)
                ->orderByDesc('sort_order')
                ->first()
            : ScheduleItem::where('day_of_week', $item->day_of_week)
                ->where('sort_order', '>', $item->sort_order)
                ->orderBy('sort_order')
                ->first();

        if ($neighbor) {
            [$itemOrder, $neighborOrder] = [$item->sort_order, $neighbor->sort_order];
            $item->update(['sort_order' => $neighborOrder]);
            $neighbor->update(['sort_order' => $itemOrder]);
        }

        return back();
    }
}
