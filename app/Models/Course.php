<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
     protected $fillable = [
        'title',
        'description',
    ];
// its for course_details only setting it for register-> enroll_students for now
    public function courseDesignWiseCourses()
    {
        return $this->hasMany(CourseDetail::class, 'course_id');
    }
}
