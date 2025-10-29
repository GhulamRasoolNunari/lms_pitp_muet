<?php

namespace App\Livewire;

use App\Models\EnrollStudent;
use Illuminate\Support\Arr;
use Livewire\Component;

class EnrollStudentsCourseChoiceWiseChart extends Component
{
    public $courseChoiceData = [];
    public $filters = [];

    protected array $courseLabels = [
        'Certified Cloud Computing Professional',
        'Certified Cyber Security and Ethical Hacking Professional',
        'Certified Data Scientist',
        'Certified Database Administrator',
        'Certified Digital Marketing Professional',
        'Certified E-Commerce Professional',
        'Certified Graphic Designer',
        'Certified Java Developer',
        'Certified Mobile Application Developer',
        'Certified Python Developer',
        'Certified Social Media Manager',
        'Certified Web Developer',
    ];

    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public function mount($filters = [])
    {
        $this->filters = $filters;
        $this->loadData();
    }

    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->loadData(true); // indicate it's an update
    }

    public function loadData($isUpdate = false)
    {
        // Initialize counts
        $courseCounts = array_fill_keys($this->courseLabels, 0);

        // Build base query
        $query = EnrollStudent::query()
            ->where('cancel_enrollment', 0)
            ->whereHas('registered_student', fn($q) => $q->where('enrolled_status', 1));

        // '' Apply filters dynamically
        if ($studyCenter = Arr::get($this->filters, 'study_center')) {
            $query->whereHas('registered_student', fn($q) => $q->where('preferred_study_center', $studyCenter));
        }

        if ($gender = Arr::get($this->filters, 'gender')) {
            $query->whereHas('registered_student', fn($q) => $q->where('gender', $gender));
        }

        if ($domicile = Arr::get($this->filters, 'domicile')) {
            $query->whereHas('registered_student', fn($q) => $q->where('domicile_district', $domicile));
        }

        if ($qualification = Arr::get($this->filters, 'highest_qualification')) {
            $query->whereHas('registered_student', fn($q) => $q->where('highest_qualification', $qualification));
        }

        if ($slot = Arr::get($this->filters, 'time_slot')) {
            $query->whereHas('registered_student', fn($q) => $q->where('preferred_time_slot', $slot));
        }

        if ($dob = Arr::get($this->filters, 'age_group')) {
            $query->whereHas('registered_student', function ($q) use ($dob) {
                if (!empty($dob['from'])) $q->where('date_of_birth', '>=', $dob['from']);
                if (!empty($dob['to'])) $q->where('date_of_birth', '<=', $dob['to']);
            });
        }

        // Fetch students
        $students = $query->with('registered_student')->get();

        // Count course choices
        foreach ($students as $enroll) {
            $student = $enroll->registered_student;
            if ($student) {
                foreach (['course_choice_1', 'course_choice_2', 'course_choice_3', 'course_choice_4'] as $choiceCol) {
                    $course = $student->$choiceCol;
                    if ($course && isset($courseCounts[$course])) {
                        $courseCounts[$course]++;
                    }
                }
            }
        }

        // Prepare chart data
        $this->courseChoiceData = [
            'labels' => array_keys($courseCounts),
            'data' => array_values($courseCounts),
        ];

        if ($isUpdate) {
            // dd($this->courseChoiceData);
            $this->dispatch('courseChoiceChartUpdated', $this->courseChoiceData);
        }
    }

    public function render()
    {
        return view('livewire.enroll-students-course-choice-wise-chart', [
            'initialCourseData' => $this->courseChoiceData,
        ]);
    }
}
