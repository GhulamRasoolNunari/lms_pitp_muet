<?php

namespace App\Livewire;

use App\Models\TimeSlot as ModelsTimeSlot;
use Livewire\Component;

class TimeSlot extends Component
{
    public $title,$id;
    public $description;
    public $status = 1;

    public function render()
    {
        $timeSlots = ModelsTimeSlot::paginate(10);
        return view('livewire.time-slot',compact('timeSlots'));
    }
    public function save()
    {
        $rules = [
            'title' => 'required|unique:campuses,title,' . $this->id,
            'description' => 'nullable|string',
        ];

        $messages = [
            'title.required' => 'The title is required.',
        ];

        $validatedData = $this->validate($rules, $messages);

        if (strlen($this->title) > 20) {
            $this->dispatch('timeSlot-saved', title: 'Error!', text: 'Title must not exceed 20 characters.', icon: 'error');
            return;
        }
        if (strlen($this->description) > 500) {
            $this->dispatch('timeSlot-saved', title: 'Error!', text: 'Description must not exceed 500 characters.', icon: 'error');
            return;
        }

        // Save or update campus
        ModelsTimeSlot::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );

        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch('timeSlot-saved', title: 'Success!', text: "Time slot has been $message successfully.", icon: 'success');

        return redirect()->route('time_slot');
    }
      public function edit($id)
    {
        $timeSlot = ModelsTimeSlot::findOrFail($id);
        $this->id = $timeSlot->id;
        $this->title = $timeSlot->title;
        $this->description = $timeSlot->description;

    }
}
