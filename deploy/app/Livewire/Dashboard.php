<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\Course;
use App\Models\EnrollStudent;
use App\Models\EnrollStudentDetail;
use App\Models\Phase;
use App\Models\StudentRegister;
use App\Models\User;
use Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $enrolledstudentsCount;

    public $registeredtudentsCount;

    public $teachersCount;

    public $coursesCount;

    public $phasesCount;

    public $campusCount;

    public $genderCounts;

    public $batchesCount;

    public $enrollments = [];

    public $courses;

    public $batches;

    public $study_center_filter;

    public $course_filter;

    public $gender_filter;

    public $domicile_category_filter;

    public $highest_qualification_filter;

    public $batch_id;

    public $age_group_filter;

    public $time_slot_filter;

    public function mount()
    {

        $query = User::query();
        $this->genderCounts = StudentRegister::selectRaw('gender, COUNT(*) as total')
            ->groupBy('gender')
            ->pluck('total', 'gender');
        $this->enrolledstudentsCount = EnrollStudent::where('cancel_enrollment', 0)->count();
        $this->registeredtudentsCount = StudentRegister::count();
        $this->teachersCount = (clone $query)
            ->where('user_type', 'teacher')
            ->count();
        $this->phasesCount = Phase::count();
        $this->batchesCount = Campus::count();
        $this->campusCount = Batch::count();
        $this->coursesCount = Course::count();
        $this->courses = [];
        $this->batches = Campus::all();
    }

    public function updatedBatchId($value)
    {
        $this->courses = Course::where('campus_id', $value)->get();
    }

    public function applyFilters()
    {
        $ageRanges = [
            'below 18' => [null, 17],
            '18–22' => [18, 22],
            '23–26' => [23, 26],
            '27-28' => [27, 28],
        ];
        // Get selected range
        $ageRange = $this->age_group_filter && isset($ageRanges[$this->age_group_filter])
            ? $ageRanges[$this->age_group_filter]
            : null;

        // Convert to DOB range if selected
        $dobRange = null;
        if ($ageRange) {
            [$minAge, $maxAge] = $ageRange;

            // If we have a max age (upper bound)
            if ($maxAge !== null) {
                $dobRange['from'] = now()->subYears($maxAge + 1)->addDay()->toDateString();
            }

            // If we have a min age (lower bound)
            if ($minAge !== null) {
                $dobRange['to'] = now()->subYears($minAge)->toDateString();
            }
        }
        // Enrolled Students Query
        $enrolledQuery = EnrollStudent::query()
            ->where('cancel_enrollment', 0)
            ->when($this->study_center_filter, fn ($q) => $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_study_center', $this->study_center_filter)
            )
            )
            ->when($this->domicile_category_filter, fn ($q) => $q->whereHas('registered_student', fn ($sub) => $sub->where('domicile_district', $this->domicile_category_filter)
            )
            )
            ->when($this->gender_filter, fn ($q) => $q->whereHas('registered_student', fn ($sub) => $sub->where('gender', $this->gender_filter)
            )
            )
            ->when($this->highest_qualification_filter, fn ($q) => $q->whereHas('registered_student', fn ($sub) => $sub->where('highest_qualification', $this->highest_qualification_filter)
            )
            )
            ->when($this->course_filter, fn ($q) => $q->whereHas('enroll_student.course', fn ($sub) => $sub->where('id', $this->course_filter)
            )
            )
            ->when($this->time_slot_filter, fn ($q) => $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_time_slot', $this->time_slot_filter)
            )
            )
            ->when($dobRange, fn ($q) => $q->whereHas('registered_student', function ($sub) use ($dobRange) {
                if (isset($dobRange['from'])) {
                    $sub->where('date_of_birth', '>=', $dobRange['from']);
                }
                if (isset($dobRange['to'])) {
                    $sub->where('date_of_birth', '<=', $dobRange['to']);
                }
            })
            );

        // Registered Students Query
        $registeredQuery = StudentRegister::query()
            ->when($this->study_center_filter, fn ($q) => $q->where('preferred_study_center', $this->study_center_filter)
            )
            ->when($this->domicile_category_filter, fn ($q) => $q->where('domicile_district', $this->domicile_category_filter)
            )
            ->when($this->highest_qualification_filter, fn ($q) => $q->where('highest_qualification', $this->highest_qualification_filter)
            )
            ->when($this->time_slot_filter, fn ($q) => $q->where('preferred_time_slot', $this->time_slot_filter)
            )
            ->when($dobRange, fn ($q) => $q->when(isset($dobRange['from']), fn ($s) => $s->where('date_of_birth', '>=', $dobRange['from'])
            )->when(isset($dobRange['to']), fn ($s) => $s->where('date_of_birth', '<=', $dobRange['to'])
            )
            )
            ->when($this->gender_filter, fn ($q) => $q->where('gender', $this->gender_filter)
            );
        $this->enrolledstudentsCount = $enrolledQuery->count();
        $this->registeredtudentsCount = $registeredQuery->count();
        $this->dispatch('filtersUpdated', [
            'study_center' => $this->study_center_filter,
            'domicile' => $this->domicile_category_filter,
            'gender' => $this->gender_filter,
            'course' => $this->course_filter,
            'age_group' => $dobRange,
            'batch_id' => $this->batch_id,
            'highest_qualification' => $this->highest_qualification_filter,
            'time_slot' => $this->time_slot_filter,
        ]);
    }

    public function render()
    {
        if (Auth::user()->user_type == 'student') {
            $this->enrollments = EnrollStudentDetail::where('student_id', Auth::user()->id)->get();
        }

        return view('livewire.dashboard');
    }
}
