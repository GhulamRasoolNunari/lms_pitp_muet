<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTestQuestionAttempt extends Model
{
    protected $fillable = [
        'test_attempt_id',
        'question_id',
        'chosen_option',
        'correct_answer',
    ];
    public function studentTestAttempt()
    {
        return $this->belongsTo(StudentTestAttempt::class, 'test_attempt_id');
    }
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
