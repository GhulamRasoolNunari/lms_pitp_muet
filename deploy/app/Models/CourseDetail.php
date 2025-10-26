<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_id',
        'campus_id',
        'batch_id',
        'phase_id',
        'time_slot_id',
        'title',
        'enroll_limit',

    ];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function time_slot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
