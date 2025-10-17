<?php

namespace App\Livewire;

use App\HasFilterHelpers;
use App\Models\EnrollStudent;
use Illuminate\Support\Arr;
use Livewire\Component;

class EnrollmentDomicileDistrictChart extends Component
{
    use HasFilterHelpers;

    public array $filters = [];

    /** Chart state for initial render */
    public array $chartLabels = [];
    public array $chartData = [];
    public array $chartBackgrounds = [
        '#27A486', '#41B87D', '#9ED96B', '#FFB347', '#F87171',
        '#60A5FA', '#A78BFA', '#F472B6', '#34D399', '#F59E0B',
        '#10B981', '#EF4444', '#6366F1', '#22D3EE', '#84CC16',
        '#D946EF', '#FB7185', '#06B6D4', '#EAB308', '#4ADE80',
        '#93C5FD', '#FCA5A5', '#FDE68A', '#A3E635', '#FDA4AF',
        '#C4B5FD', '#67E8F9', '#89CFF0', '#9CA3AF', '#D1D5DB',
    ];

    // Listen for the same event you’re already emitting globally
    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public function mount($filters = [])
    {
        $this->filters = $filters;
        $this->loadData();
    }

    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->loadData(isUpdate: true);
    }

    /**
     * Build base query with your existing filter semantics,
     * then count per district via the registered_student relation.
     */
    public function loadData(bool $isUpdate = false): void
    {
        $districtMap = config('filters.districts', []); // ['badin'=>'Badin', ...]
        $slugs  = array_keys($districtMap);
        $labels = array_values($districtMap); // Pretty names

        // Start with core constraints
        $base = EnrollStudent::query()
            ->where('cancel_enrollment', 0)
            // study_center (on registered_student.preferred_study_center)
            ->when(filled($center = Arr::get($this->filters, 'study_center')), function ($q) use ($center) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_study_center', $center));
            })
            // highest_qualification (on registered_student.highest_qualification)
            ->when(filled($hq = Arr::get($this->filters, 'highest_qualification')), function ($q) use ($hq) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('highest_qualification', $hq));
            })
            // time_slot (on registered_student.preferred_time_slot)
            ->when(filled($timeSlot = Arr::get($this->filters, 'time_slot')), function ($q) use ($timeSlot) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('preferred_time_slot', $timeSlot));
            })
            // user-applied domicile filter: if present, we’ll limit the base set
            ->when(filled($domicile = Arr::get($this->filters, 'domicile')), function ($q) use ($domicile) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('domicile_district', $domicile));
            })
            // age_group (date_of_birth on registered_student)
            ->when(filled($ageGroup = Arr::get($this->filters, 'age_group')), function ($q) use ($ageGroup) {
                $q->whereHas('registered_student', function ($sub) use ($ageGroup) {
                    if (!empty($ageGroup['from'])) {
                        $sub->where('date_of_birth', '>=', $ageGroup['from']);
                    }
                    if (!empty($ageGroup['to'])) {
                        $sub->where('date_of_birth', '<=', $ageGroup['to']);
                    }
                });
            })
            // gender (on registered_student.gender)
            ->when(filled($gender = Arr::get($this->filters, 'gender')), function ($q) use ($gender) {
                $q->whereHas('registered_student', fn ($sub) => $sub->where('gender', $gender));
            })
            // batch_id and course filters live directly on enroll_students in most schemas
            ->when(filled($batchId = Arr::get($this->filters, 'batch_id')), fn ($q) => $q->where('batch_id', $batchId))
            ->when(filled($course = Arr::get($this->filters, 'course')), fn ($q) => $q->where('course_id', $course));

        // Count per district (respecting any filters above)
        $counts = [];
        foreach ($slugs as $slug) {
            $counts[] = (clone $base)->whereHas('registered_student', function ($sub) use ($slug) {
                $sub->where('domicile_district', $slug);
            })->count();
        }

        $this->chartLabels = $labels;
        $this->chartData   = $counts;

        if ($isUpdate) {
            // Reuse your Alpine listener name for seamless updates
            $this->dispatch(
                'educationChartUpdated',
                labels: $this->chartLabels,
                data: $this->chartData,
                backgroundColor: $this->chartBackgrounds
            );
        }
    }

    public function render()
    {
        // Pack initial payload for Alpine
        $payload = [
            'labels'          => $this->chartLabels,
            'data'            => $this->chartData,
            'backgroundColor' => $this->chartBackgrounds,
        ];

        return view('livewire.enrollment-domicile-district-chart', [
            'educationGroupData' => $payload,
        ]);
    }
}
