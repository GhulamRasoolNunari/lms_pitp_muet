<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [

        'question_id',
        'quiz_id'
    ];
public function question(){
    return $this->belongsTo(Question::class);
}
}
