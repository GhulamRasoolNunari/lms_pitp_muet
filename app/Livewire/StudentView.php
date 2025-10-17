<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\EnrollStudentDetail;
use App\Models\User;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;


class StudentView extends Component
{
    protected $paginationTheme = 'tailwind';
    use WithPagination;

    public $course_id = null;
    public function render()
    {
        // $courses = Auth::user()->courses()->with('batch')->get();
        $courses = CourseDetail::with(['user', 'course', 'campus', 'batch', 'time_slot'])
        ->where('user_id', auth()->id())
        ->get();
        
        $students = [];

        if ($this->course_id != null) {
            $course = collect($courses)->where('id', $this->course_id)->first();
            $students = EnrollStudentDetail::with('student.student', 'batch', 'course')
            ->where([
                'campus_id' => $course->campus_id,
                'batch_id' => $course->batch_id,
                'course_id' => $course->course_id,
            ])
            ->whereHas('student') // Only include records where the student relation is not null
            ->paginate(10);
        }
        return view('livewire.student-view', compact('courses','students'));
    }

    public function updatedCourseId($value)
    {
        $this->course_id = $value;
    }


}
