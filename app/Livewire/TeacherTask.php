<?php

namespace App\Livewire;

use App\Models\CourseDetail;
use App\Models\SubmitedTask;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\TeacherTask as TeacherTaskModel;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class TeacherTask extends Component
{
    use WithFileUploads;
    protected $paginationTheme = 'tailwind';
    use WithPagination;

    public $id , $task_title, $task_description, $number_of_days, $total_marks = 5, $attachment_link, $course_id, $assigned_task  ;
    public $submitedTasks = [], $submitedTasksCount = 0, $marks = [];

    public function render()
    {
        // $courses = Auth::user()->courses()->with('batch')->paginate(10);

        $course_detail = CourseDetail::with(['course', 'batch'])->where('user_id', auth()->id())->get();

        $teacherTasks = TeacherTaskModel::where('teacher_id', Auth::user()->id)->paginate(10);
        return view('livewire.teacher-task',compact('course_detail','teacherTasks'));
    }
    public function save(){

        $rules = [
            'task_title' => 'required|string|max:255',
            'task_description' => 'required|string',
            'number_of_days' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:0',
            // 'attachment_link' => $this->id ? 'nullable' : 'required|file|mimes:pdf,doc,docx|max:2048', // 2MB max
            'attachment_link' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // 2MB max
            'course_id' => 'required|exists:course_details,id',
        ];
        $message = [
            'task_title.required' => 'Task title is required.',
            'task_description.required' => 'Task description is required.',
            'number_of_days.required' => 'Number of days is required.',
            'total_marks.required' => 'Total marks are required.',
            // 'attachment_link.required' => 'Attachment is required.',
            'attachment_link.file' => 'Attachment must be a file.',
            'course_id.required' => 'Course selection is required.',
            'course_id.exists' => 'Selected course does not exist.',
        ];
        $validatedData = $this->validate($rules, $message);
        $validatedData['teacher_id'] = Auth::user()->id;

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
        if ($this->id) {
            // Update user
            if (!$this->attachment_link) {
                unset($validatedData['attachment_link']);
            }
        }
        TeacherTaskModel::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );

        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch(
            'task-saved',
            title: 'Success!',
            text: "Task has been $message successfully.",
            icon: 'success',
        );
    }
    public function edit($id)
    {
        $task = TeacherTaskModel::find($id);
        if ($task) {
            $this->id = $task->id;
            $this->task_title = $task->task_title;
            $this->task_description = $task->task_description;
            $this->number_of_days = $task->number_of_days;
            $this->total_marks = $task->total_marks;
            $this->course_id = $task->course_id;
        } else {
            $this->dispatch(
                'task-not-found',
                title: 'Error!',
                text: "Task not found.",
                icon: 'error',
            );
        }
    }
    function update_task($id)
    {
        $this->assigned_task = 1;
        TeacherTaskModel::where('id', $id)->update(['assigned_task' => $this->assigned_task  ]);
        $this->dispatch(
            'task-saved',
            title: 'Success!',
            text: "Task has been Assigend successfully.",
            icon: 'success',
        );

    }
    function view_task($id)
    {
        // dd($id);
        $this->submitedTasks = collect(
            SubmitedTask::with('user')
            ->where('task_id', $id)
            ->get()
        );
        $this->submitedTasksCount = $this->submitedTasks->count();

        foreach ($this->submitedTasks as $task) {
            $this->marks[$task->id] = $task->obtain_marks;
        }

        $this->dispatch('open-task-view-modal');
    }
    public function marksUpdated($value, $key)
    {
        if ($value === null) {
            return;
        }
        $task = SubmitedTask::find($key);

        if ($task) {
            $task->obtain_marks = $value;
            $task->save();
        }
        $this->dispatch(
            'marks-saved',
            title: 'Success!',
            text: "Marks has been saved  successfully.",
            icon: 'success',
        );
    }
    public function confirmDelete($q_id)
    {
        $this->id = $q_id;
        $this->dispatch('swal-confirm');
    }
    public function deleteCourse()
    {
        TeacherTaskModel::destroy($this->id);
        $this->dispatch('task-saved', title: 'Deleted!', text: 'Task has been deleted successfully.', icon: 'success');
    }
}
