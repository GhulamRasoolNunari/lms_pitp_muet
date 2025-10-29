<?php

namespace App\Livewire;

use Livewire\Component;

class MetricCard extends Component
{
        public string $headingLabel;
    public int $count = 0;
    public function render()
    {
        return view('livewire.metric-card');
    }
}
