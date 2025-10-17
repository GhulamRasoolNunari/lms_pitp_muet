<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
    ];
      public function timeSlotDesignWiseCourses()
    {
        return $this->hasMany(CourseDetail::class, 'time_slot_id');
    }
}
