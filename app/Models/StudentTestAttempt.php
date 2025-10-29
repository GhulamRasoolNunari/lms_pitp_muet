<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentTestAttempt extends Model
{

    protected $fillable = [
        'quiz_id',
        'student_id',
        'test_started',
        'test_timer',
        'questions_count',
        'is_completed',
        'wrong_ans',
        'correct_ans',
        'percentage',
    ];
    protected $casts = [
        'is_completed' => 'boolean', // Cast the `status` field to boolean
    'test_started' => 'boolean', // Cast the `test_started` field to boolean
    ];
    public function getPercentageWithSymbolAttribute()
    {
        return $this->percentage . '%';
    }
    public function getCreatedAtHumanAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y');
    }
}
