<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressLog extends Model
{
    protected $fillable = [
        'student_id',
        'part_number',
        'surah_name',
        'from_ayah',
        'to_ayah',
        'score',
        'next_homework'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
