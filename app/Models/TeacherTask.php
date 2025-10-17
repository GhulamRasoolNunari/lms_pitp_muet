<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherTask extends Model
{
    protected $fillable = [
        'teacher_id',
        'task_title',
        'task_description',
        'number_of_days',
        'total_marks',
        'attachment_link',
        'course_id',
        'assigned_task'
    ];
    function update_task() {
        return $this->hasOne(SubmitedTask::class, 'task_id')
                ->where('user_id', auth()->user()->id);
    }
}
