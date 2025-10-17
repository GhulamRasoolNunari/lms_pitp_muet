<?php

namespace App\Livewire;

use App\Models\EnrollStudent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class EnrollByTimeSlot extends Component
{
    public $timeSlotData;
    public $morning = [];
    public $afternoon = [];
    public $earlyEvening = [];
    public $lateEvening = [];
    public $weekend = [];
    public $colors = [];
    public $filters = [];

    protected $slotColors = [
        'Morning' => '#FFC107',
        'Afternoon' => '#63B0E4',
        'Early Evening' => '#009788',
        'Late Evening' => '#4CAF50',
        'Weekend' => '#9C27B0',
    ];

    // Listen for Dashboard filters
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
        // labels come from config (same as you had)
        $centerLabels = array_keys(Config::get('filters.study_centers', []));
        $groupedSlotsMap = [
            'Morning' => ['9 AM to 12 PM'],
            'Afternoon' => ['12 PM to 3 PM'],
            'Early Evening' => ['3 PM to 6 PM'],
            'Late Evening' => ['6 PM to 9 PM'],
            'Weekend' => ['Sat & Sun (Weekend)'],
        ];

        $numCenters = count($centerLabels);

        // init arrays (ensure same length as labels)
        $this->morning = array_fill(0, $numCenters, 0);
        $this->afternoon = array_fill(0, $numCenters, 0);
        $this->earlyEvening = array_fill(0, $numCenters, 0);
        $this->lateEvening = array_fill(0, $numCenters, 0);
        $this->weekend = array_fill(0, $numCenters, 0);

        $this->colors = [
            'morning' => $this->slotColors['Morning'],
            'afternoon' => $this->slotColors['Afternoon'],
            'earlyEvening' => $this->slotColors['Early Evening'],
            'lateEvening' => $this->slotColors['Late Evening'],
            'weekend' => $this->slotColors['Weekend'],
        ];

        // Build base query and apply filters from $this->filters
        $query = EnrollStudent::query()
            ->where('cancel_enrollment', 0)
            ->whereHas('registered_student', fn($q) => $q->where('enrolled_status', 1));

        // apply filters exactly like Dashboard sends them
        if (!empty(Arr::get($this->filters, 'study_center'))) {
            $query->whereHas('registered_student', fn($q) => $q->where('preferred_study_center', Arr::get($this->filters, 'study_center')));
        }

        if (!empty(Arr::get($this->filters, 'gender'))) {
            $query->whereHas('registered_student', fn($q) => $q->where('gender', Arr::get($this->filters, 'gender')));
        }

        if (!empty(Arr::get($this->filters, 'domicile'))) {
            $query->whereHas('registered_student', fn($q) => $q->where('domicile_category', Arr::get($this->filters, 'domicile')));
        }

        if (!empty(Arr::get($this->filters, 'highest_qualification'))) {
            $query->whereHas('registered_student', fn($q) => $q->where('highest_qualification', Arr::get($this->filters, 'highest_qualification')));
        }

        if (!empty(Arr::get($this->filters, 'time_slot'))) {
            $query->whereHas('registered_student', fn($q) => $q->where('preferred_time_slot', Arr::get($this->filters, 'time_slot')));
        }

        // age_group (dobRange) if supplied
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

        if (!empty(Arr::get($this->filters, 'course'))) {
            // if your relationships differ adjust this: original used enroll_student relation in some queries
            $query->whereHas('enroll_student', fn($q) => $q->where('course_id', Arr::get($this->filters, 'course')));
        }

        // fetch and group
        $enrollmentCounts = $query->with('registered_student')->get()
            ->groupBy(function ($enroll) {
                return $enroll->registered_student->preferred_study_center . '|' . $enroll->registered_student->preferred_time_slot;
            })
            ->map->count();

        foreach ($enrollmentCounts as $key => $count) {
            [$centerName, $slotValue] = explode('|', $key);
            $centerIndex = array_search($centerName, $centerLabels);

            // find group name from our map
            $groupName = null;
            foreach ($groupedSlotsMap as $group => $slots) {
                if (in_array($slotValue, $slots)) {
                    $groupName = $group;
                    break;
                }
            }

            if ($centerIndex !== false && $groupName) {
                switch ($groupName) {
                    case 'Morning':
                        $this->morning[$centerIndex] = $count;
                        break;
                    case 'Afternoon':
                        $this->afternoon[$centerIndex] = $count;
                        break;
                    case 'Early Evening':
                        $this->earlyEvening[$centerIndex] = $count;
                        break;
                    case 'Late Evening':
                        $this->lateEvening[$centerIndex] = $count;
                        break;
                    case 'Weekend':
                        $this->weekend[$centerIndex] = $count;
                        break;
                }
            }
        }

        // if everything zero -> gray colors (so chart doesn't show old colors)
        $total = array_sum($this->morning) + array_sum($this->afternoon) + array_sum($this->earlyEvening)
            + array_sum($this->lateEvening) + array_sum($this->weekend);

        if ($total === 0) {
            $this->colors = array_map(fn() => '#E5E7EB', $this->colors); // gray
        }

        $this->timeSlotData = [
            'labels' => $centerLabels,
            'colors' => $this->colors,
        ];

        // If invoked as update, dispatch browser event with same signature pattern you use elsewhere
        if ($isUpdate) {
            // dd($this->timeSlotData);
            // dd($this->morning);
            // dd($this->afternoon);

            $this->dispatch('timeSlotChartUpdated',
                labels: $this->timeSlotData['labels'],
                morning: $this->morning,
                afternoon: $this->afternoon,
                earlyEvening: $this->earlyEvening,
                lateEvening: $this->lateEvening,
                weekend: $this->weekend,
                colors: $this->colors
            );
        }
    }

    public function render()
    {
        return view('livewire.enroll-by-time-slot', [
            'timeSlotData' => $this->timeSlotData,
            'morning' => $this->morning,
            'afternoon' => $this->afternoon,
            'earlyEvening' => $this->earlyEvening,
            'lateEvening' => $this->lateEvening,
            'weekend' => $this->weekend,
            'colors' => $this->colors,
        ]);
    }
}
