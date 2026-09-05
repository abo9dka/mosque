<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressLog extends Model
{
    const PASS_THRESHOLD = 6;

    protected $fillable = [
        'student_id',
        'type',

// الحفظ الجديد
'surah',
'surah_number',
'from_ayah',
'to_ayah',
'score',

'homework',
'daily_review',
'review_score',
'review_homework',
'notes',

// المراجعة الكبرى
'weekly_memorization',

];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * فشل الطالب في هذا الحفظ (العلامة أقل من الحد الأدنى)، فلا يُحتسب
     * ضمن نسبة إنجاز حفظ القرآن رغم بقائه ظاهرًا في السجل.
     */
    public function isFailed(): bool
    {
        return $this->type === 'memorization'
            && $this->score !== null
            && $this->score < self::PASS_THRESHOLD;
    }
}
