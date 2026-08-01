<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    public const STATUS_PRESENT = 'حاضر';
    public const STATUS_EXCUSED_ABSENCE = 'غياب بعذر';
    public const STATUS_UNEXCUSED_ABSENCE = 'غياب بدون عذر';
    public const STATUS_LATE = 'متأخر';

    protected $fillable = ['student_id', 'status', 'absence_reason', 'date'];

    // السجل ينتمي لطالب واحد
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // عدد النقاط التي تُخصم بسبب هذه الحالة
    public static function penaltyFor(?string $status): int
    {
        return match ($status) {
            self::STATUS_UNEXCUSED_ABSENCE => 10,
            self::STATUS_LATE => 5,
            default => 0,
        };
    }
}
