<?php

namespace App\Livewire;

use App\Models\EnrollStudent;
use Illuminate\Support\Arr;
use Livewire\Component;

class DomicileWiseEnrollmentChart extends Component
{
    public $filters = [];
    public $domicileData = [];

    // Listen for dashboard filter updates
    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public function mount($filters = [])
    {
        $this->filters = $filters;
        $this->loadData();
    }

    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->loadData(true);
    }

    public function loadData($isUpdate = false)
    {
        $query = EnrollStudent::query()
            ->where('cancel_enrollment', 0)
            ->whereHas('registered_student', fn($q) => $q->where('enrolled_status', 1));

        // '' Study Center filter
        if ($studyCenter = Arr::get($this->filters, 'study_center')) {
            $query->whereHas('registered_student', fn($q) =>
                $q->where('preferred_study_center', $studyCenter)
            );
        }

        // '' Gender filter
        if ($gender = Arr::get($this->filters, 'gender')) {
            $query->whereHas('registered_student', fn($q) =>
                $q->where('gender', $gender)
            );
        }

        // '' Domicile filter (handles both string or array values safely)
        if ($domicile = Arr::get($this->filters, 'domicile')) {
            $query->whereHas('registered_student', function ($q) use ($domicile) {
                if (is_array($domicile)) {
                    $q->whereIn('domicile_district', $domicile);
                } else {
                    $q->where('domicile_district', $domicile);
                }
            });
        }

        // '' Highest Qualification filter
        if ($qualification = Arr::get($this->filters, 'highest_qualification')) {
            $query->whereHas('registered_student', fn($q) =>
                $q->where('highest_qualification', $qualification)
            );
        }

        // '' Time Slot filter
        if ($slot = Arr::get($this->filters, 'time_slot')) {
            $query->whereHas('registered_student', fn($q) =>
                $q->where('preferred_time_slot', $slot)
            );
        }

        // '' Age group filter
        if ($dob = Arr::get($this->filters, 'age_group')) {
            $query->whereHas('registered_student', function ($q) use ($dob) {
                if (!empty($dob['from'])) {
                    $q->where('date_of_birth', '>=', $dob['from']);
                }
                if (!empty($dob['to'])) {
                    $q->where('date_of_birth', '<=', $dob['to']);
                }
            });
        }

        // '' Course filter
        if ($course = Arr::get($this->filters, 'course')) {
            $query->where('course_id', $course);
        }

        // 🔹 Fetch and group results
        $results = $query->with('registered_student')
            ->get()
            ->groupBy(fn($enroll) => $enroll->registered_student->domicile_category ?? 'Unknown')
            ->map->count();

        $labels = $results->keys()->toArray();
        $counts = $results->values()->toArray();

        // 🔹 Define colors dynamically
        $backgrounds = ['#27A486', '#41B87D', '#9ED96B', '#FFB347', '#F87171'];
        $borderColors = ['#1F7861', '#30B58B', '#77AA53', '#FF8C00', '#E11D48'];

        $this->domicileData = [
            'labels' => $labels,
            'data' => $counts,
            'backgrounds' => $backgrounds,
            'borders' => $borderColors,
        ];

        // 🔹 Dispatch event to update chart on frontend (only if filters applied)
        if ($isUpdate) {
            $this->dispatch('domicileChartUpdated', [
                'labels' => $labels,
                'data' => $counts,
                'backgrounds' => $backgrounds,
                'borders' => $borderColors,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.domicile-wise-enrollment-chart', [
            'domicileData' => $this->domicileData,
        ]);
    }
}
