<?php

namespace App\Support;

use Carbon\Carbon;

class ArabicDate
{
    /**
     * أسماء أيام الأسبوع بالعربية، مرقّمة وفق ترقيم Carbon/PHP نفسه
     * (0 = الأحد ... 6 = السبت) — نفس الترقيم المخزَّن في schedule_items.day_of_week.
     */
    public const DAY_NAMES = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];

    /**
     * تنسيق تاريخ بشكل عربي جميل، مثال: "السبت، 5 سبتمبر".
     */
    public static function label(Carbon $date): string
    {
        $monthNames = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل', 5 => 'مايو', 6 => 'يونيو',
            7 => 'يوليو', 8 => 'أغسطس', 9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر',
        ];

        return self::dayName($date->dayOfWeek) . '، ' . $date->day . ' ' . $monthNames[$date->month];
    }

    /**
     * اسم يوم الأسبوع بالعربية فقط، حسب رقمه (0 = الأحد ... 6 = السبت).
     */
    public static function dayName(int $dayOfWeek): string
    {
        return self::DAY_NAMES[$dayOfWeek] ?? '';
    }
}
