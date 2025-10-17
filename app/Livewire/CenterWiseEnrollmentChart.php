<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EnrollStudent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CenterWiseEnrollmentChart extends Component
{
    public $filters = [];
    public $centerGroupData = [];

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
        $query = EnrollStudent::where('enroll_students.cancel_enrollment', 0)
            ->join('student_registers', 'enroll_students.cnic_number', '=', 'student_registers.cnic_number')
            ->select('student_registers.preferred_study_center', DB::raw('COUNT(*) as count'))
            ->groupBy('student_registers.preferred_study_center');

        // Apply filters dynamically
        if ($studyCenter = Arr::get($this->filters, 'study_center')) {
            $query->where('student_registers.preferred_study_center', $studyCenter);
        }
        if ($gender = Arr::get($this->filters, 'gender')) {
            $query->where('student_registers.gender', $gender);
        }
        if ($domicile = Arr::get($this->filters, 'domicile')) {
            if (is_array($domicile)) {
                $query->whereIn('student_registers.domicile_district', $domicile);
            } else {
                $query->where('student_registers.domicile_district', $domicile);
            }
        }
        if ($qualification = Arr::get($this->filters, 'highest_qualification')) {
            $query->where('student_registers.highest_qualification', $qualification);
        }
        if ($slot = Arr::get($this->filters, 'time_slot')) {
            $query->where('student_registers.preferred_time_slot', $slot);
        }
        if ($dob = Arr::get($this->filters, 'age_group')) {
            if (!empty($dob['from'])) $query->where('student_registers.date_of_birth', '>=', $dob['from']);
            if (!empty($dob['to'])) $query->where('student_registers.date_of_birth', '<=', $dob['to']);
        }

        $results = $query->get();

        $labels = $results->pluck('preferred_study_center')->toArray();
        $counts = $results->pluck('count')->toArray();

        // Colors
        $backgroundColors = ['#27A486', '#41B87D', '#9ED96B', '#FFB347', '#6A5ACD', '#E9967A', '#20B2AA', '#9370DB'];
        $borderColors     = ['#1F7861', '#30B58B', '#77AA53', '#FF8C00', '#483D8B', '#CD5C5C', '#008B8B', '#4B0082'];

        $this->centerGroupData = [
            'labels' => $labels,
            'data' => $counts,
            'backgroundColor' => $backgroundColors,
            'borderColor' => $borderColors,
        ];

        if ($isUpdate) {
        // dd($this->centerGroupData);

            $this->dispatch('centerChartUpdated', [$this->centerGroupData]);
        }
    }

    public function render()
    {
        return view('livewire.center-wise-enrollment-chart', [
            'centerGroupData' => $this->centerGroupData,
        ]);
    }
}
