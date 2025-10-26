<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\Course;
use App\Models\User;
use App\Models\Teacher as TeacherModel;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomSession;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class Teacher extends Component
{
    use WithPagination;
    public $id, $full_name, $email, $phone, $password,$search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $teachers = User::where('user_type', 'teacher')
        ->where('is_active', '1')
        ->where(function ($query) {
            $query->where('full_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('livewire.teacher', compact('teachers', ));
    }

    public function save()
    {
        // dd($this->all());
        $rules = [
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => $this->id ? 'nullable' : 'required',
        ];

        $messages = [
            'full_name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email has already been taken.',
            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'Phone number has already been taken.',
            'password.required' => 'Password is required.',
        ];

        // Update ke liye unique ignore karna
        if ($this->id) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->id;
            $rules['phone'] = 'required|unique:users,phone,' . $this->id;
        }

        $validatedData = $this->validate($rules, $messages);

        // Common fields
        $validatedData['user_type'] = 'teacher';
        $validatedData['is_active'] = '1';

        // Password sirf agar diya gaya ho
        if ($this->password) {
            $validatedData['password'] = Hash::make($this->password);
        }

        if ($this->id) {
            // Update user
            if (!$this->password) {
                unset($validatedData['password']); // Agar password empty hai to skip
            }
            User::where('id', $this->id)->update($validatedData);
            $message = 'Trainer Updated Successfully';
        } else {
            // Create new user
            $user = User::create($validatedData);
            $message = 'Trainer Created Successfully';
        }

        // Reset form
        $this->reset();

        // Alert
        $this->dispatch(
            'teacher-saved',
            title: 'Success!',
            text: $message,
            icon: 'success',
        );

        sleep(1);

        return redirect()->route('create_teacher');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Set form fields
        $this->full_name = $user->full_name ?? $user->firstname . ' ' . $user->lastname;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->password = null; // leave password empty
        $this->id = $user->id;

        // Dispatch if you want to scroll or open modal (optional)
        $this->dispatch('edit-mode');
    }

    // public function confirmDelete($courseId)
    // {
    //     $this->id = $courseId;
    //     $this->dispatch('swal-confirm');
    // }
    // public function deleteCourse()
    // {
    //     User::destroy($this->id); // Find the course by ID

    //     $this->dispatch('course-deleted', title: 'Deleted!', text: 'Teacher has been deleted successfully.', icon: 'success');
    // }

}
