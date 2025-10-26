<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title',
        'question',
        'correct_answer',
        'options',
        'teacher_id'
        // 'marks',
        // 'images',
        // 'description',
        // 'desc_images',
        // 'video_link',
        // 'is_publish',
    ];
}
