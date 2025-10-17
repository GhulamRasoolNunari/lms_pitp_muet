<?php

namespace App\Livewire;

use App\Models\SubmitedTask;
use Carbon\Carbon;
use App\Models\TeacherTask;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentTask extends Component
{
    public $task_title, $task_description, $number_of_days, $attachment_link, $group_name;

    public function render()
    {

        $user = Auth::user();
        $enrolledCourseIds = $user->std_details()->pluck('course_id')->toArray();
        $submittedTaskIds = SubmitedTask::where('user_id', $user->id)
        ->pluck('task_id')
        ->toArray();
        if ($user) {
            $tasks = TeacherTask::whereIn('course_id', $enrolledCourseIds)
                ->where('assigned_task', 1)
                ->get()
                ->map(function ($task) use ($submittedTaskIds) {
                    $assignedAt = Carbon::parse($task->updated_at);
                    $dueDays = (int) ($task->number_of_days ?? 0);
                    $dueDate = $assignedAt->copy()->addDays($dueDays);
                    $now = Carbon::now(); // Get current time

                    $task->assigned_time = $assignedAt->format('Y-m-d h:i A');
                    $task->due_time = $dueDate->format('Y-m-d h:i A');
                    $task->is_submitted = in_array($task->id, $submittedTaskIds);

                    $diffInSeconds = $now->diffInSeconds($dueDate, false);

                    if ($diffInSeconds > 86400) {
                        // More than 1 day left
                        $task->remaining_time = floor($diffInSeconds / 86400) . ' days left';
                    } elseif ($diffInSeconds > 3600) {
                        // Less than 1 day but more than 1 hour
                        $task->remaining_time = floor($diffInSeconds / 3600) . ' hours left';
                    } elseif ($diffInSeconds > 60) {
                        // Less than 1 hour but more than 1 minute
                        $task->remaining_time = floor($diffInSeconds / 60) . ' minutes left';
                    } elseif ($diffInSeconds > 0) {
                        // Less than 1 minute
                        $task->remaining_time = $diffInSeconds . ' seconds left';
                    } else {
                        // Date has passed
                        $task->remaining_time = 'The task date has passed';
                    }

                    return $task;
                });
        } else {
            $tasks = collect();
        }

        return view('livewire.student-task',compact('tasks'));
    }
    function view_task($id)
    {
        $task_detail = TeacherTask::where('id', $id)->firstOrFail();
        $this->task_title = $task_detail->task_title;
        $this->task_description = $task_detail->task_description;
        $this->number_of_days = $task_detail->number_of_days;
        $this->attachment_link = $task_detail->attachment_link;
        $this->dispatch('open-task-view-modal');
    }
}
