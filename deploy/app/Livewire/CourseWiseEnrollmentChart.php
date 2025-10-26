<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\EnrollStudentDetail;

class CourseWiseEnrollmentChart extends Component
{
        public $courseGroupData;
   public function mount()
    {
        // group course_id and count
        $results = EnrollStudentDetail::with('course')
            ->select('course_id', DB::raw('COUNT(*) as count'))
            ->groupBy('course_id')
            ->get();

        // labels from relation, counts from query
        $labels = $results->map(fn ($row) => optional($row->course)->title)->toArray();
        $counts = $results->pluck('count')->toArray();

        // Assign colors dynamically (cycle colors if more courses)
        $backgroundColors = ['#27A486', '#41B87D', '#9ED96B', '#FFB347', '#6A5ACD', '#E9967A'];
        $borderColors     = ['#1F7861', '#30B58B', '#77AA53', '#FF8C00', '#483D8B', '#CD5C5C'];

        $this->courseGroupData = [
            'labels' => $labels,
            'data' => $counts,
            'backgroundColor' => $backgroundColors,
            'borderColor' => $borderColors,
        ];
    }
    public function render()
    {
        return view('livewire.course-wise-enrollment-chart');
    }
}
