<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressLog extends Model
{
    protected $fillable = [
        'student_id',
        'type',

// الحفظ الجديد
'surah',
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
}
