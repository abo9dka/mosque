<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'name', 'phone_number'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function progressLogs()
    {
        return $this->hasMany(ProgressLog::class);
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
