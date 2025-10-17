<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['title', 'description','teacher_id', 'course_detail_id','for_date',  'marks', 'duration'];

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
