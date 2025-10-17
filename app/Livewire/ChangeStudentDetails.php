<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\CourseDetail;
// use App\Models\Student;
use App\Models\EnrollStudentDetail;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ChangeStudentDetails extends Component
{
    public $show = false;

    public $ids = [];

    public $campuses = [];

    public $batches = [];

    public $courses = [];

    public $timeSlots = [];

    public $campus_id;

    public $time_slot_id;

    public $realtime_campus_id;

    public $batch_id;

    public $course_id;

    public $preferred_study_center;

    public $preferred_time_slot;

    #[On('open-change-details-modal')]
    public function open($ids)
    {
        $this->ids = $ids;
        $this->timeSlots = TimeSlot::all();
        $this->show = true;
    }

    public function updatedCampusId($value)
    {
        $this->batches = Batch::whereHas('courseDesignWiseBatch', function ($q) use ($value) {
            $q->where('campus_id', $value);
        })->where('status', 1)->get();
        $this->realtime_campus_id = $value;
        $this->batch_id = null;
        $this->courses = [];
        $this->course_id = null;
    }

    // when batch changes
    public function updatedBatchId($value)
    {
        $this->courses = CourseDetail::where('batch_id', $value)->get();
        $this->course_id = null;
    }

    public function save()
    {
        try {

            DB::transaction(function () {
                $ids = data_get($this->ids, 'ids', []);
                if (empty($ids)) {
                    throw new \RuntimeException('Please select at least one student.');
                }

                $this->validate([
                    'campus_id' => ['required', 'exists:campuses,id'],
                    'batch_id' => ['required', 'exists:batches,id'],
                    'course_id' => ['required', 'exists:course_details,id'],
                ], [
                    'campus_id.required' => 'The campus field is required.',
                    'batch_id.required' => 'The batch field is required.',
                    'course_id.required' => 'The course field is required.',
                ]);

                $courseDetail = CourseDetail::find($this->course_id);
                $updates = array_filter([
                    'campus_id' => $courseDetail->campus_id,
                    'batch_id' => $courseDetail->batch_id,
                    'course_id' => $courseDetail->course_id,
                    'course_detail_id' => $courseDetail->id,
                ], fn ($v) => filled($v));
                $currentCount = EnrollStudentDetail::query()
                    ->where('course_id', $courseDetail->course_id)
                    ->where('campus_id', $courseDetail->campus_id)
                    ->where('batch_id', $courseDetail->batch_id)
                    ->join('enroll_students', 'enroll_students.student_id', '=', 'enroll_student_details.student_id')
                    ->where('enroll_students.cancel_enrollment', 0)
                    ->join('student_registers', 'student_registers.cnic_number', '=', 'enroll_students.cnic_number')
                    ->where('student_registers.enrolled_status', 1) // filter only not cancelled
                    ->lockForUpdate()
                    ->count();
                if ($currentCount >= $courseDetail->enroll_limit ?? 50) {
                    $this->dispatch(
                        'toast',
                        title: 'This course already has '.($course_detail->enroll_limit ?? 50).' students enrolled.',
                        icon: 'error',
                    );

                }
                EnrollStudentDetail::whereIn('student_id', $ids)->update($updates);

            });
            $this->show = false;

            $this->dispatch(
                'toast',
                title: 'Student Has Been Updated Successfully.',
                icon: 'success',
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'toast',
                title: $e->getMessage(),
                icon: 'error',
            );
        }

    }

    public function mount()
    {
        $this->campuses = Campus::all();
        $this->batches = [];
        $this->courses = [];
    }

    public function render()
    {
        return view('livewire.change-student-details');
    }
}
