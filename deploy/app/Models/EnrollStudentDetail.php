<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollStudentDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'campus_id',
        'batch_id',
        'course_id',
        'time_slot_id',
        'course_detail_id'
    ];
    public function student()
    {
        return $this->belongsTo(EnrollStudent::class, 'student_id');
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function time_slot()
    {
        return $this->belongsTo(TimeSlot::class, 'time_slot_id');
    }
}
