<?php

namespace App\Livewire;

use App\HasFilterHelpers;
use App\Models\EnrollStudent;
use Illuminate\Support\Arr;
use Livewire\Component;

class EnrollStudentGenderChart extends Component
{
    use HasFilterHelpers;

    // Public properties to hold data for initial render
    public $chartLabels = ['Male', 'Female', 'Transgender'];

    public $chartData = [0, 0, 0];

    public $chartBackgrounds = ['#4BC0C0', '#FF6384', '#FFCE56'];

    public $filters = [];

    // Livewire 3 listener syntax
    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public function mount($filters = [])
    {
        $this->filters = $filters;
        $this->loadData();
    }

    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->loadData(true); // Indicate update for dispatching event
    }

    public function loadData($isUpdate = false)
    {
        $baseQuery = EnrollStudent::query()
            ->where('cancel_enrollment', 0)
            ->when(filled($center = Arr::get($this->filters, 'study_center')), function ($q) use ($center) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_study_center', $center));
            })
            ->when(filled($highestQualification = Arr::get($this->filters, 'highest_qualification')), function ($q) use ($highestQualification) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('highest_qualification', $highestQualification));
            })
            ->when(filled($timeSlot = Arr::get($this->filters, 'time_slot')), function ($q) use ($timeSlot) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_time_slot', $timeSlot));
            })
            ->when(filled($domicile = Arr::get($this->filters, 'domicile')), function ($q) use ($domicile) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('domicile_district', $domicile));
            })
            ->when(filled($ageGroup = Arr::get($this->filters, 'age_group')), function ($q) use ($ageGroup) {
                if (! empty($ageGroup['from'])) {
                    $q->where('date_of_birth', '>=', $ageGroup['from']);
                }
                if (! empty($ageGroup['to'])) {
                    $q->where('date_of_birth', '<=', $ageGroup['to']);
                }
            })
            ->when(filled($gender = Arr::get($this->filters, 'gender')), function ($q) use ($gender) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('gender', $gender));
            })
            ->when(filled($batchId = Arr::get($this->filters, 'batch_id')), function ($q) use ($batchId) {
                $q->whereHas('enroll_student.campus', fn ($sub) => $sub->where('id', $batchId));
            })
            ->when(filled($course = Arr::get($this->filters, 'course')), function ($q) use ($course) {
                $q->whereHas('enroll_student', fn ($sub) => $sub->where('course_id', $course));
            });

        $maleCount = (clone $baseQuery)->where('gender', 'male')->count();
        $femaleCount = (clone $baseQuery)->where('gender', 'female')->count();
        $transgenderCount = (clone $baseQuery)->where('gender', 'transgender')->count();

        $this->chartData = [$maleCount, $femaleCount, $transgenderCount];

        if ($isUpdate) {
            // Dispatch a single event with the complete structure
            $this->dispatch('chartDataUpdated',
                labels: $this->chartLabels,
                data: $this->chartData,
                backgrounds: $this->chartBackgrounds
            );
        }
    }

    public function render()
    {
        return view('livewire.enroll-student-gender-chart', [
            'initialLabels' => $this->chartLabels,
            'initialData' => $this->chartData,
            'initialBackgrounds' => $this->chartBackgrounds,
        ]);
    }
}
