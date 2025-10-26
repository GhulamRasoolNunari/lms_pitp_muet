<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\CustomSession;
use App\Models\Question as DataQuestion;
use Livewire\Component;

class Question extends Component
{
    public   $title, $question, $id, $options = [], $correct_answer;

    public function render()
    {
        // dd('s')
        $questions = DataQuestion::paginate(100);
        return view('livewire.question', compact('questions'));
    }
    public function save()
    {
        $rules = [
            'title' => 'required|string|max:255',

            'question' => 'required|string',
            'correct_answer' => 'required',
        ];
        $messages = [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not exceed 255 characters.',

            'question.required' => 'The question field cannot be empty.',
            'question.string' => 'The question must be valid text.',
            'correct_answer.required' => 'Please mark one option as the correct answer.',
        ];
        $validatedData = $this->validate($rules, $messages);
        $validatedData['options'] = serialize(json_decode($this->options, true));
        $validatedData['teacher_id'] = auth()->user()->id;

        DataQuestion::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );
        $message = $this->id ? 'updated' : 'saved';

        $this->reset();
        $this->dispatch(
            'question-saved',
            title: 'Success!',
            text: "Question has been $message successfully.",
            icon: 'success',
        );
    }
    public function edit($id)
    {
        $question = DataQuestion::find($id);

        $this->title = $question->title;
        $this->question = $question->question;
        $this->correct_answer = $question->correct_answer;
        $this->options = $question->options;
        $this->id = $id;
        $this->dispatch(
            'edit-question-loaded',
            options: unserialize($this->options),
            correct_answer: $this->correct_answer,
        );
    }
}
