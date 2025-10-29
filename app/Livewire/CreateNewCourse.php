<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class CreateNewCourse extends Component
{
    use WithPagination;

    public $search = '';

    public $title;

    public $description;

    public $id;

    // public $campuses = [];

    public $batches = [];

    public function render()
    {
        $courses = Course::where(function ($query) {
            $query->where('title', 'like', '%'.$this->search.'%');
        })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.create-new-course', compact('courses'));
    }

    public function save()
    {
        $rules = [
            'title' => 'required|unique:campuses,title,'.$this->id,
            'description' => 'required',
        ];

        $messages = [
            'title.required' => 'The title is required.',
            'description.required' => 'The description is required.',
        ];
        $validatedData = $this->validate($rules, $messages);
        if (strlen($this->title) > 20) {
            $this->dispatch('course-saved', title: 'Error!', text: 'Title must not exceed 20 characters.', icon: 'error');

            return;
        }
        if (strlen($this->description) > 500) {
            $this->dispatch('course-saved', title: 'Error!', text: 'Description must not exceed 500 characters.', icon: 'error');

            return;
        }
        // Save or update campus
        Course::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );

        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch('course-saved', title: 'Success!', text: "Course has been $message successfully.", icon: 'success');
    }

}
