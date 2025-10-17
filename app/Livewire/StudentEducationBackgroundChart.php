<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EnrollStudent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StudentEducationBackgroundChart extends Component
{
    public $filters = [];
    public $educationGroupData = [];

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
        $labels = ['Matric', 'Intermediate', 'Graduate'];
        $educationGroups = array_fill_keys($labels, 0);

        $query = EnrollStudent::where('enroll_students.cancel_enrollment', 0)
            ->join('student_registers', 'enroll_students.cnic_number', '=', 'student_registers.cnic_number');

        // Apply filters
        if (!empty(Arr::get($this->filters, 'study_center'))) {
            $query->where('student_registers.preferred_study_center', Arr::get($this->filters, 'study_center'));
        }

        if (!empty(Arr::get($this->filters, 'gender'))) {
            $query->where('student_registers.gender', Arr::get($this->filters, 'gender'));
        }

        if (!empty(Arr::get($this->filters, 'highest_qualification'))) {
            $query->where('student_registers.highest_qualification', Arr::get($this->filters, 'highest_qualification'));
        }

        if (!empty(Arr::get($this->filters, 'time_slot'))) {
            $query->where('student_registers.preferred_time_slot', Arr::get($this->filters, 'time_slot'));
        }

        if (!empty(Arr::get($this->filters, 'age_group'))) {
            $dob = Arr::get($this->filters, 'age_group');
            if (!empty($dob['from'])) {
                $query->where('student_registers.date_of_birth', '>=', $dob['from']);
            }
            if (!empty($dob['to'])) {
                $query->where('student_registers.date_of_birth', '<=', $dob['to']);
            }
        }

        if (!empty(Arr::get($this->filters, 'domicile'))) {
            $domicile = Arr::get($this->filters, 'domicile');
            if (is_array($domicile)) {
                $query->whereIn('student_registers.domicile_district', $domicile);
            } else {
                $query->where('student_registers.domicile_district', $domicile);
            }
        }

        if (!empty(Arr::get($this->filters, 'course'))) {
            $query->where('enroll_students.course_id', Arr::get($this->filters, 'course'));
        }

        // Group by highest_qualification
        $results = $query->select(DB::raw('student_registers.highest_qualification'), DB::raw('COUNT(*) as count'))
            ->groupBy('student_registers.highest_qualification')
            ->get();

        foreach ($results as $result) {
            $qualification = strtolower($result->highest_qualification);
            switch ($qualification) {
                case 'matric':
                    $educationGroups['Matric'] = $result->count;
                    break;
                case 'intermediate':
                    $educationGroups['Intermediate'] = $result->count;
                    break;
                case 'graduate':
                    $educationGroups['Graduate'] = $result->count;
                    break;
            }
        }

        $this->educationGroupData = [
            'labels' => array_keys($educationGroups),
            'data' => array_values($educationGroups),
            'backgroundColor' => ['#27A486', '#41B87D', '#9ED96B'],
            'borderColor' => ['#1F7861', '#30B58B', '#77AA53'],
        ];

        if ($isUpdate) {
            $this->dispatch('educationChartUpdated', $this->educationGroupData);
        }
    }

    public function render()
    {
        return view('livewire.student-education-background-chart');
    }
}
