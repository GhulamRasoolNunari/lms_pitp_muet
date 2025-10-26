<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseCampus as CourseCampusModel;
use Livewire\Component;

class CourseCampus extends Component
{
    public $campus_id;

    public $course_id;

    public $description;

    public $id;
    // public function mount()
    // {

    // }
    public function render()
    {
        $courseCampuses = CourseCampusModel::paginate(10);
        $campuses = Batch::all();
        $courses = Course::all();

        return view('livewire.course-campus', compact('courseCampuses', 'campuses', 'courses'));
    }

    public function save()
    {
        $rules = [
            'campus_id' => 'required',
            'course_id' => 'required',
            'description' => 'nullable',
        ];

        $messages = [
            'campus_id.required' => 'The Course is required.',
            'course_id.required' => 'The Campus is required.',
        ];

        $validatedData = $this->validate($rules, $messages);
        // Save or update campus
        CourseCampusModel::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );

        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch('courseCampus-saved', title: 'Success!', text: "Course Campus has been $message successfully.", icon: 'success');
    }

    public function edit($id)
    {
        $courseCampus = CourseCampusModel::findOrFail($id);
        $this->campus_id = $courseCampus->campus_id;
        $this->course_id = $courseCampus->course_id;
        $this->description = $courseCampus->description;
        $this->id = $courseCampus->id;
    }
}
