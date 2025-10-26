<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\Question;
use App\Models\Quiz as QuizModel;
use App\Models\QuizQuestion;
use Livewire\Component;

class Quiz extends Component
{
    public $title;

    public $description;

    public $duration;

    public $marks;

    public $id;

    public $course_id;

    public $updatedCampusId;

    public $teachersAddedQuestion;

    public $checkedId;

    public bool $showGrabbedQuestion = false;

    //   dependent dropdowns vars declare
    public $batches;

    public $courses;
    public $for_date;

    public $campuses = [];


    // declaring it for hook call on modal live
    public $selectedCourseDetail = null;

    public $selectedBatch = null;

    public array $selectedRows = [];

    // public function mount()
    // {
    // }
    public function render()
    {
        $quizes = QuizModel::paginate(10);
        $course_details = CourseDetail::where('user_id', auth()->id())->get();

        return view('livewire.quiz', compact('quizes','course_details'));
    }

    // public function updatedselectedCourseDetail($campus)
    // {
    //     $this->batches = Batch::where('status', '1')->where('campus_id', $campus)->select('id', 'campus_id', 'title')->get();
    //     $this->selectedBatch = null;
    //     $this->courses = null;
    // }
    // public function updatedSelectedBatch($batch)
    // {
    //     if (empty($batch)) {
    //         $this->courses = null;
    //         $this->selectedCourseDetail = null;
    //     }
    //     $this->courses = Course::where('batch_id', $batch)->select('id', 'title', 'batch_id')->get();
    // }
    public function save()
    {
        $rules = [
            'selectedRows' => 'required',
            'for_date' => 'required',
            'title' => 'required',
            'description' => 'required',
            'marks' => 'required',
            'duration' => 'required',
            'selectedCourseDetail' => 'required',
        ];

        $messages = [
            'title.required' => 'The title is required.',
            'for_date.required' => 'For Date is required.',
            'description.required' => 'The description is required.',
            'marks.required' => 'The marks is required.',
            'duration.required' => 'The duration is required.',
            'selectedCourseDetail.required' => 'The selected Course is required.',
            'selectedRows.required' => 'You must select a question to proceed.',
        ];
        $validatedData = $this->validate($rules, $messages);
        // After validation, rename the keys

        $validatedData['teacher_id'] = auth()->id();
        $validatedData['course_detail_id'] = $validatedData['selectedCourseDetail'];
        // Remove the original keys
        // unset($validatedData['selectedCourseDetail']);
        $validatedData['duration'] = $this->convertMinutesToTime($this->duration);
        $createdQuiz = QuizModel::updateOrCreate(
            ['id' => $this->id],
            $validatedData
        );

        $quizQuestion = [];
        foreach ($this->selectedRows as $questionId) {
            $quizQuestion[] = [
                'question_id' => $questionId,
                'quiz_id' => $createdQuiz->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        QuizQuestion::where('quiz_id', $createdQuiz->id)->delete();
        if (! empty($quizQuestion)) {
            QuizQuestion::insert($quizQuestion);
        }
        // else {
        // }
        $message = $this->id ? 'updated' : 'saved';

        $this->reset();
        $this->dispatch(
            'quiz-saved',
            title: 'Success!',
            text: "Quiz has been $message successfully.",
            icon: 'success',
        );
    }

    public function showQuestionTeacherWise()
    {
        $this->teachersAddedQuestion = Question::where('teacher_id', auth()->id())->get();
        $this->showGrabbedQuestion = true;
    }

    public function edit($id)
    {
        $quiz = QuizModel::findOrFail($id);
        // dd($quiz);
        $this->title = $quiz->title;
        $this->selectedCourseDetail = $quiz->course_detail_id;
        $this->for_date = $quiz->for_date;
        $this->description = $quiz->description;
        $this->id = $quiz->id;
        $this->duration = $this->timeToMinutes($quiz->duration);
        $this->marks = $quiz->marks;
        $this->selectedRows = QuizQuestion::where('quiz_id', $id)->pluck('question_id')->toArray();
        $this->showQuestionTeacherWise();
    }

    public function convertMinutesToTime($totalMinutes)
    {
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return str_pad($hours, 2, '0', STR_PAD_LEFT).':'.
            str_pad($minutes, 2, '0', STR_PAD_LEFT).':00';
    }

    public function timeToMinutes($time)
    {
        [$hours, $minutes, $seconds] = explode(':', $time);

        return ((int) $hours * 60) + (int) $minutes;
    }
}
