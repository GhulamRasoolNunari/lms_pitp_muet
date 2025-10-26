<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Component
{
    public $firstnameText, $lastnameText, $full_name, $lastname, $password,$password_confirmation;

    public function mount()
    {
        $this->firstnameText = auth()->user()->full_name;
        // $this->lastnameText = auth()->user()->lastname;
    }
    public function render()
    {
        return view('livewire.edit-profile');
    }
    public function edit()
    {
        $validated = $this->validate(
            [
                'full_name' => 'required',
                // 'lastname' => 'required',
                'password' => 'nullable|confirmed',
            ]
        );
        if (empty($validated['password'])) {
            unset($validated['password']);
        }
        $user = tap(User::find(Auth::id()))->update($validated);
        $this->dispatch(
            'profile-updated',
            title: 'Success!',
            text: "Profile has been updated successfully.",
            icon: 'success',
        );
        $this->firstnameText = $user->full_name;
        $this->lastnameText = $user->lastname;
    }
    public function loadProfileData()
    {
        $user = User::find(auth()->user()->id);
        $this->full_name = $user->full_name;
        // $this->lastname = $user->lastname;
        $this->password='';
        $this->password_confirmation='';

        $this->dispatch('open-profile-modal');
    }
}
