<?php

namespace App\Livewire;

use App\Models\EnrollStudent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EnrollStudentAgeGroup extends Component
{
    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public $filters = [];

    public $ageGroupData;

    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->loadData(true); // Indicate update for dispatching event
    }

    public function mount()
    {
        $this->loadData();
    }

    public function loadData($isUpdate = false)
    {
        $labels = [
            'Below 18',
            '18-20',
            '21-22',
            '23-24',
            '25-26',
            '27-28',
        ];
        $ageGroups = array_fill_keys($labels, 0);

    //     $results = EnrollStudent::select(DB::raw('
    //     CASE
    //         WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) < 18 THEN "Below 18"
    //         WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 18 AND 20 THEN "18-20"
    //         WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 21 AND 22 THEN "21-22"
    //         WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 23 AND 24 THEN "23-24"
    //         WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 25 AND 26 THEN "25-26"
    //         WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 27 AND 28 THEN "27-28"
    //         ELSE "Other"
    //     END as age_group_label
    // '), DB::raw('COUNT(*) as count'))
    //         ->where('cancel_enrollment', 0)

    //         ->when(filled($center = Arr::get($this->filters, 'study_center')), function ($q) use ($center) {
    //             $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_study_center', $center));
    //         })
    //         ->when(filled($gender = Arr::get($this->filters, 'gender')), function ($q) use ($gender) {
    //             $q->whereHas('registered_student', fn ($sub) => $sub->where('gender', $gender));
    //         })
    //         ->when(filled($domicile = Arr::get($this->filters, 'domicile')), function ($q) use ($domicile) {
    //             $q->whereHas('registered_student', fn ($sub) => $sub->where('domicile_category', $domicile));
    //         })
    //         ->when(filled($timeSlot = Arr::get($this->filters, 'time_slot')), function ($q) use ($timeSlot) {
    //             $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_time_slot', $timeSlot));
    //         })
    //         ->when(filled($highestQualification = Arr::get($this->filters, 'highest_qualification')), function ($q) use ($highestQualification) {
    //             $q->whereHas('registered_student', fn ($sub) => $sub->where('highest_qualification', $highestQualification));
    //         })
    //         ->groupBy('age_group_label')
    //         ->get();
        $results = EnrollStudent::select(DB::raw('
    CASE
        WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) < 18 THEN "Below 18"
        WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 18 AND 20 THEN "18-20"
        WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 21 AND 22 THEN "21-22"
        WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 23 AND 24 THEN "23-24"
        WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 25 AND 26 THEN "25-26"
        WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 27 AND 28 THEN "27-28"
        ELSE "Other"
    END as age_group_label
'), DB::raw('COUNT(*) as count'))
    ->where('cancel_enrollment', 0)
    ->when(filled($center = Arr::get($this->filters, 'study_center')), fn ($q) =>
        $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_study_center', $center))
    )
    ->when(filled($gender = Arr::get($this->filters, 'gender')), fn ($q) =>
        $q->whereHas('registered_student', fn ($sub) => $sub->where('gender', $gender))
    )
    ->when(filled($domicile = Arr::get($this->filters, 'domicile')), fn ($q) =>
        $q->whereHas('registered_student', fn ($sub) => $sub->where('domicile_district', $domicile))
    )
    ->when(filled($timeSlot = Arr::get($this->filters, 'time_slot')), fn ($q) =>
        $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_time_slot', $timeSlot))
    )
    ->when(filled($highestQualification = Arr::get($this->filters, 'highest_qualification')), fn ($q) =>
        $q->whereHas('registered_student', fn ($sub) => $sub->where('highest_qualification', $highestQualification))
    )
    ->when($dobRange = Arr::get($this->filters, 'age_group'), fn ($q) =>
        $q->whereHas('registered_student', function ($sub) use ($dobRange) {
            if (isset($dobRange['from'])) {
                $sub->where('date_of_birth', '>=', $dobRange['from']);
            }
            if (isset($dobRange['to'])) {
                $sub->where('date_of_birth', '<=', $dobRange['to']);
            }
        })
    )
    ->groupBy('age_group_label')
    ->get();

        foreach ($results as $result) {
            if (array_key_exists($result->age_group_label, $ageGroups)) {
                $ageGroups[$result->age_group_label] = $result->count;
            }
        }

        $this->ageGroupData = [
            'labels' => array_keys($ageGroups),
            'data' => array_values($ageGroups),
            'backgroundColor' => [
                '#4BC0C0', '#36A2EB', '#FFCE56', '#FF6384', '#9966FF', '#FF9F40',
            ],
            'borderColor' => [
                '#3182CE', '#2B6CB0', '#C05621', '#9B2C2C', '#553C9A', '#744210',
            ],
        ];

        if ($isUpdate) {
            // dd($this->ageGroupData);
            $this->dispatch('chartDataUpdated', data: $this->ageGroupData);
        }
    }

    public function render()
    {
        return view('livewire.enroll-student-age-group', [
            'initialLabels' => $this->ageGroupData['labels'] ,
            'initialData' => $this->ageGroupData['data'] ,
            'initialBackgrounds' => $this->ageGroupData['backgroundColor'] ,
            'initialBorders' => $this->ageGroupData['borderColor'] ,
        ]);
    }
}
