<?php

namespace App\Livewire;

use App\Models\Programme;
use Livewire\Component;
use Livewire\WithPagination;

class ProgrammeCreate extends Component
{
    use WithPagination;
    public $search = '', $title, $description, $id, $editMode = false;
    protected $paginationTheme = 'tailwind';
    public function render()
    {
        $programmes = Programme::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('livewire.programme-create',compact('programmes'));
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
            $this->dispatch('programme-saved', title: 'Error!', text: 'Title must not exceed 20 characters.', icon: 'error');
            return;
        }
        if (strlen($this->description) > 500) {
            $this->dispatch('programme-saved', title: 'Error!', text: 'Description must not exceed 500 characters.', icon: 'error');
            return;
        }

        // Save or update campus
        Programme::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );

        $message = $this->id ? 'updated' : 'saved';
        $this->reset();
        $this->dispatch('programme-saved', title: 'Success!', text: "Programme has been $message successfully.", icon: 'success');
        sleep(1);

        return redirect()->route('show_programme');

    }
    public function edit($id)
    {
        $phase = Programme::findOrFail($id);
        $this->title = $phase->title;
        $this->description = $phase->description;
        $this->id = $phase->id;
        $this->editMode = true;
    }
}
