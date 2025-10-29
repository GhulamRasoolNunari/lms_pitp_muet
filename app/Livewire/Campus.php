<?php

namespace App\Livewire;

use App\Models\Phase;
use Livewire\Component;
use App\Models\Campus as CampusModel;
use Livewire\WithPagination;

class Campus extends Component
{
    use WithPagination;
    protected $paginationTheme='tailwind';
    public $title, $description, $id, $search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $campuses = CampusModel::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('livewire.campus',compact('campuses'));
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
            $this->dispatch('campus-saved', title: 'Error!', text: 'Title must not exceed 20 characters.', icon: 'error');
            return;
        }
        if (strlen($this->description) > 500) {
            $this->dispatch('campus-saved', title: 'Error!', text: 'Description must not exceed 500 characters.', icon: 'error');
            return;
        }

        // Save or update campus
        CampusModel::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );

        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch('campus-saved', title: 'Success!', text: "Batch has been $message successfully.", icon: 'success');

    }
    public function edit($id)
    {
        $campus = CampusModel::findOrFail($id);
        $this->title = $campus->title;
        $this->description = $campus->description;
        $this->id = $campus->id;
    }
}
