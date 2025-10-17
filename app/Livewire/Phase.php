<?php

namespace App\Livewire;
use App\Models\Phase as PhaseModel;
use Livewire\Component;
use Livewire\WithPagination;


class Phase extends Component
{
    use WithPagination;
    public $search = '', $title, $description, $id,$phaseId;
    protected $paginationTheme = 'tailwind';
    public function render()
    {
        $phases = PhaseModel::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('livewire.phase',compact('phases'));
    }
    public function save()
    {
        $rules = [
            'title' => 'required|unique:campuses,title,' . $this->id,
            'description' => 'required',
        ];

        $messages = [
            'title.required' => 'The title is required.',
            'description.required' => 'The description is required.',
        ];

        $validatedData = $this->validate($rules, $messages);

        if (strlen($this->title) > 20) {
            $this->dispatch('phase-saved', title: 'Error!', text: 'Title must not exceed 20 characters.', icon: 'error');
            return;
        }
        if (strlen($this->description) > 500) {
            $this->dispatch('phase-saved', title: 'Error!', text: 'Description must not exceed 500 characters.', icon: 'error');
            return;
        }

        // Save or update campus
        PhaseModel::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );

        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch('phase-saved', title: 'Success!', text: "Phase has been $message successfully.", icon: 'success');

        return redirect()->route('show_phase');

    }
    public function edit($id)
    {
        $phase = PhaseModel::findOrFail($id);
        $this->title = $phase->title;
        $this->description = $phase->description;
        $this->id = $phase->id;
    }
    //  public function delete($id)
    // {
    //     $course = PhaseModel::findOrFail($id);
    //     $this->course_title = $course->course_title;
    //     $this->course_description = $course->course_description;
    //     $this->questions_limit = $course->questions_limit;
    //     $this->minutes = $this->timeToMinutes($course->test_time);
    //     $this->Duration = $course->Duration;
    //     $this->update_id = $course->id;
    // }
    public function confirmDelete($phaseId)
    {
        $this->phaseId = $phaseId;
        $this->dispatch('swal-confirm');
    }
   public function deletePhase(int $id)
{
    // dd($id);
    // your delete logic...
    // Phase::findOrFail($id)->delete();

    $this->dispatch('toast', icon: 'success', title: 'Deleted', text: 'Phase deleted successfully.');
}
}
