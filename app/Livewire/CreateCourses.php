<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\Phase;
use App\Models\TimeSlot;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CreateCourses extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $campus_id;

    public $phase_id;

    public $user_id;

    public $course_id;

    public $time_slot_id;

    public $title;

    public $enroll_limit;

    public $description;

    public $id;

    public $batch_id;

    public $time_slot;

    public $courseIdToDelete;

    public $search = '';

    public $editMode = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $phases = Phase::select('id', 'title')->get();
        $batches = Batch::select('id', 'title')->get();
        $campuses = Campus::select('id', 'title')->get();
        $courses = Course::select('id', 'title')->get();
        $users = User::where('user_type', 'teacher')->get();
        $course_details = CourseDetail::with('campus', 'time_slot', 'batch', 'user', 'phase')
            ->whereHas('course', function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        $time_slots = TimeSlot::all();

        return view('livewire.create-courses', compact('course_details', 'users', 'phases', 'campuses', 'time_slots', 'courses', 'batches'));
    }

    public function save()
    {

        $rules = [
            'phase_id' => 'required',
            'batch_id' => 'required',
            'campus_id' => 'required',
            'course_id' => 'required',
            'user_id' => 'required',
            'time_slot_id' => 'required',
            'title' => 'required',
            'enroll_limit' => 'required',
        ];
        $message = [
            'course_id.required' => 'Course is required.',
            'time_slot_id.required' => 'Time Slot is required.',
            'campus_id.required' => 'Campus is required.',
            'batch_id.required' => 'Batch is required.',
            'user_id.required' => 'Teacher is required.',
            'phase_id.required' => 'Phase is required.',
            'title.required' => 'Course ID is required',
            'enroll_limit.required' => 'Enrollment limit must be provided',
        ];
        $validated = $this->validate($rules, $message);
        // 🔁 Swap campus_id and batch_id
        $temp = $validated['campus_id'];
        $validated['campus_id'] = $validated['batch_id'];
        $validated['batch_id'] = $temp;
        CourseDetail::updateOrCreate(
            ['id' => $this->id],
            $validated
        );
        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch(
            'course-saved',
            title: 'Success!',
            text: "Design course has been $message successfully.",
            icon: 'success',
        );

        return redirect()->route('courses_create');
    }

    public function edit($id)
    {
        $course = CourseDetail::findOrFail($id);
        $this->id = $course->id;
        $this->title = $course->title;
        $this->batch_id = $course->batch_id;
        $this->campus_id = $course->campus_id;
        $this->user_id = $course->user_id;
        $this->course_id = $course->course_id;
        $this->time_slot_id = $course->time_slot_id;
        $this->enroll_limit = $course->enroll_limit;
        $this->phase_id = $course->phase_id;
        $this->editMode = true;
    }

    // public function delete($id)
    // {
    //     $course = Course::findOrFail($id);
    //     $this->course_title = $course->course_title;
    //     $this->course_description = $course->course_description;
    //     $this->questions_limit = $course->questions_limit;
    //     [$hours, $minutes, $seconds] = explode(':', $course->test_time);
    //     $this->hours = $hours;
    //     $this->minutes = $minutes;
    //     $this->Duration = $course->Duration;
    //     $this->update_id = $course->id;
    // }

    public function confirmDelete($courseId)
    {
        $this->courseIdToDelete = $courseId;
        $this->dispatch('swal-confirm');
    }

    public function deleteCourse()
    {
        // dd($this->courseIdToDelete);

        Course::destroy($this->courseIdToDelete);
        $this->dispatch('course-deleted', title: 'Deleted!', text: 'Course has been deleted successfully.', icon: 'success');
    }
}
