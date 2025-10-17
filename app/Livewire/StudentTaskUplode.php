<?php

namespace App\Livewire;

use App\Models\SubmitedTask;
use App\Models\TeacherTask;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;


class StudentTaskUplode extends Component
{
    use WithFileUploads;
    public $task_id,$description,$attachment_link,$file_link,$id;
    public function render()
    {
        $user = auth()->user();
        // dd($user);
        $enrolledCourseIds = $user->std_details()->pluck('course_id')->toArray();


        if ($enrolledCourseIds) {
            $tasks = TeacherTask::whereIn('course_id', $enrolledCourseIds)->where('assigned_task', 1)
                ->whereDoesntHave('update_task')
                ->get();
        } else {
            $tasks = collect();
        }

        return view('livewire.student-task-uplode',compact('tasks'));
    }
    function save()
    {
        $validatedData = $this->validate([
            'task_id' => 'required',
            'description' => 'required|string|max:255',
            'attachment_link' => 'required|file|mimes:zip,rar',
            'file_link'=>'nullable|max:255'
        ], [
            'attachment_link.mimes' => 'Only .zip or .rar files are allowed.',
            'attachment_link.required' => 'Please upload a file.',
            'attachment_link.max' => 'The file size must not exceed 5MB..',

        ]);
        //   Get the task
        $task = TeacherTask::find($this->task_id);

        // Calculate the deadline
        $deadlineDate = Carbon::parse($task->updated_at)->addDays((int) $task->number_of_days);

        // Check if deadline has passed
        if (Carbon::now()->greaterThan($deadlineDate)) {
            // Show error using dispatch event (not validation error)
            $this->dispatch(
                'task-saved',
                title: 'Deadline Passed',
                text: 'The deadline for this task has passed. You can no longer upload your submission.',
                icon: 'error',
            );
            return;
        }
        $validatedData['user_id'] = auth()->user()->id;
        if ($this->attachment_link) {
            $file = $this->attachment_link;
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('attachments');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $sourcePath = $file->getRealPath();
            $destinationFile = $destinationPath . DIRECTORY_SEPARATOR . $filename;
            $contents = file_get_contents($sourcePath);
            file_put_contents($destinationFile, $contents);
            $validatedData['attachment_link'] = $filename;
        }
        $existingSubmission = SubmitedTask::where('user_id', auth()->id())
            ->where('task_id', $this->task_id)
            ->first();
        if ($existingSubmission) {
            $message = 'Your Task Has Already Been Submitted';
        } else {
            SubmitedTask::create($validatedData);
            $message = 'Your Task Has Been Submitted';
        }
        $this->reset();
        $this->dispatch(
            'task-saved',
            title: 'Success!',
            text: $message,
            icon: 'success',
        );
    }
}
