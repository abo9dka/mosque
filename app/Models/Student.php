<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'parent_id', 'name', 'phone_number', 'grade', 'address'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
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
