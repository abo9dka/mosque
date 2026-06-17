<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = ['student_id', 'status', 'date'];

    // السجل ينتمي لطالب واحد
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
