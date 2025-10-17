<?php

namespace App\Livewire;

use App\Models\Campus as BatchGroup;
// Batch acting as campus
use App\Models\Batch as Campus;
use App\Models\Phase;
use Livewire\Component;
use Livewire\WithPagination;

class Batch extends Component
{
    // Notes Campus Everuwhere denotes batch
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $campus_id, $title, $description, $id, $search = '',$campuses = [];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        // campus are batches and
        $batches = Campus::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('livewire.batch', compact('batches'));
    }

    public function save()
    {
        $rules = [
            'title' => 'required|unique:batches,title,' . $this->id,
            'description' => 'required',
        ];
        $messages = [
            'title.required' => 'The title is required.',
            'description.required' => 'The description is required.',
        ];
        // Validate the data
        $validatedData = $this->validate($rules,$messages);
        Campus::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );
        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch(
            'batches-saved',
            title: 'Success!',
            text: "Campus has been $message successfully.",
            icon: 'success',
        );

        // return redirect()->route('show_batches');
    }
    public function edit($id)
    {
        $batch = Campus::find($id);
        $this->title = $batch->title;
        $this->description = $batch->description;
        $this->id = $id;
    }
    // public function toggleStatus($id)
    // {

    //     $batch = BatchGroup::findOrFail($id);
    //     $batch->status = !$batch->status;
    //     $batch->save();

    //     $statusText = $batch->status ? 'activated' : 'deactivated';

    //     $this->dispatch(
    //         'batches-saved',
    //         title: 'Success!',
    //         text: "Campus has been $statusText successfully.",
    //         icon: 'success',
    //     );
    // }
}
