<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendace extends Model
{
    protected $fillable = ['student_id', 'date', 'is_present'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
