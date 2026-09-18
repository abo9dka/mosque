<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleItem extends Model
{
    protected $fillable = [
        'day_of_week',
        'content',
        'sort_order',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'sort_order' => 'integer',
    ];

    public function scopeForDay($query, int $dayOfWeek)
    {
        return $query->where('day_of_week', $dayOfWeek)->orderBy('sort_order');
    }
}
