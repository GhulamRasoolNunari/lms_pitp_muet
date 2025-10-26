<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\User;
use Livewire\Component;
use App\Models\StudentTestAttempt;
use App\Models\StudentTestQuestionAttempt;
use Illuminate\Support\Facades\Auth;

class StartTest extends Component
{
    public $quizId, $quizRecord, $testStarted = false, $isCompleted = false, $totalTestTimeInSeconds, $currentIndex = 0, $questions, $questionCount, $currentQuestion;
    public $studentSelectedOption, $latestTestAttemptRecord;
    public $correctAnswerCount = 0, $wrongAnswerCount = 0;
    //result data
    // 1.result card
    public $totalStudentAttemptedQuest = 0, $resultPercentage = 0, $testAttemptedDate;
    public int $durationMinutesForResultCard = 0;
    // 2. result modal
    public $resultModalData = [];
    public $showIncorrectAnswersOnly;
    //result data end
    public int $durationMinutes = 0;
    public int $durationSeconds = 0;
    protected $listeners = ['setRemainingTime' => 'setRemainingTime'];
    public function mount($id)
    {
        // isCompleted will be updated in two conditions whether time is up or question attempt count ends
        $this->quizId = $id;
        $this->setInitialData();
    }
    public function render()
    {
        $user = Auth::user();
        return view('livewire.start-test', compact('user'));
    }
    public function startTest()
    {
        $quizRecord =  $this->quizRecord->load(['quizQuestions', 'quizQuestions.question']);
        $data = [
            'quiz_id' => $this->quizId,
            'student_id' => auth()->id(),
            'test_started' => '1',
            'test_timer' => $quizRecord->duration,
            'questions_count' => $this->questionCount,
        ];
        // an attempt has been marked
        $studentAttempt =  StudentTestAttempt::create($data);
        $this->latestTestAttemptRecord = $studentAttempt;
        $this->isCompleted = false;
        $this->testStarted = true;
        $duration = $studentAttempt->test_timer;
        $this->totalTestTimeInSeconds = $this->convertToSeconds($duration);
        [$this->durationMinutes, $this->durationSeconds] = $this->convertToMinutesAndSeconds($duration);
        // Student Test Attempt
        // 'quiz_id(will get campus,course from here),student_id,test_started,test_timer,questions_count,wrong_answ(count),correct_ans(count),percentage
        // student test questions attempt
        // test_attempt_id, question_id,chosen_option(selected by student),correct_answer
    }
    public function submitAnswer()
    {
        // totalStudentAttemptedQuest
        //  percentage
        // grab correct answer before increment to make sure you are getting current question correct answer

        $currentQuestion = $this->currentQuestion;
        $correctAnswer = $currentQuestion->correct_answer;
        $questionId = $currentQuestion->id;
        $this->currentIndex++;
        $data = [
            'test_attempt_id' => $this->latestTestAttemptRecord->id,
            'chosen_option' => $this->studentSelectedOption,
            'correct_answer' => $correctAnswer,
            'question_id' => $questionId
        ];
        $currentAttemptedQuestionRecord = StudentTestQuestionAttempt::create($data);
        // realtime updating correct and wrong ans count on selected answer basis
        if ($currentAttemptedQuestionRecord->chosen_option === $currentAttemptedQuestionRecord->correct_answer) {
            $this->correctAnswerCount++;
        } else {
            $this->wrongAnswerCount++;
        }
        $this->latestTestAttemptRecord->update([
            'correct_ans' => strval($this->correctAnswerCount),
            'wrong_ans' => strval($this->wrongAnswerCount)
        ]);

        if ($this->currentIndex >= $this->questionCount) {
            $this->isCompleted = true;
            $latestTestAttemptRecord = $this->latestTestAttemptRecord;
            $this->totalStudentAttemptedQuest = $this->correctAnswerCount + $this->wrongAnswerCount;
            $this->resultPercentage = $this->measurePercentage($latestTestAttemptRecord->correct_ans, $latestTestAttemptRecord->questions_count);
            $this->latestTestAttemptRecord->update([
                'is_completed' => '1',
                'percentage' => floatval($this->resultPercentage),
            ]);
            $this->testAttemptedDate = $latestTestAttemptRecord->created_at_human ?? '';
        } else {
            // keep changing question on submit
            $this->currentQuestion = $this->quizRecord->quizQuestions->get($this->currentIndex)->question ?? null;
        }
        $studentTestQuestionsAttempt = $this->studentTestQuestionsAttempt();
        $this->loadIncorrectAnswers($studentTestQuestionsAttempt);
    }
    public function showResultModal()
    {
        $this->dispatch('show-result');
    }
    private function measurePercentage($obtain, $total)
    {
        $percentage = round(($obtain / $total) * 100, 2) . '%';
        return $percentage;
    }
    public function setRemainingTime($time)
    {
        // dd($this->latestTestAttemptRecord);
        // as ten seconds passed the timer will be updated
        $this->latestTestAttemptRecord->update([
            'test_timer' => $time,
        ]);
        //    when time is up mark test as completed
        if ($time === 0) {
            $latestTestAttemptRecord = $this->latestTestAttemptRecord;
            $this->totalStudentAttemptedQuest = $this->correctAnswerCount + $this->wrongAnswerCount;
            $this->resultPercentage = $this->measurePercentage($latestTestAttemptRecord->correct_ans, $latestTestAttemptRecord->questions_count);
            $this->isCompleted = true;
            $this->latestTestAttemptRecord->update([
                'is_completed' => '1',
            ]);
            $this->testAttemptedDate = $latestTestAttemptRecord->created_at_human ?? '';
        }
    }

    private function convertToSeconds($time)
    {
        [$hours, $minutes, $seconds] = explode(':', $time);
        return ((int)$hours * 3600) + ((int)$minutes * 60) + (int)$seconds;
    }
    private function convertToMinutesAndSeconds($time)
    {
        if (!$time) return [0, 0];

        [$hours, $minutes, $seconds] = explode(':', $time);

        $totalMinutes = ((int) $hours * 60) + (int) $minutes;
        return [$totalMinutes, (int) $seconds];
    }
    private function setInitialData()
    {
        $quiz = Quiz::with(['quizQuestions', 'quizQuestions.question', 'course'])->withCount('quizQuestions')->find($this->quizId);
        $query = StudentTestAttempt::where('quiz_id', $this->quizId)
            ->where('student_id', Auth::id())
            ->select('id', 'is_completed', 'percentage', 'correct_ans', 'wrong_ans', 'test_started','test_timer');
        $studentAttempt = (clone $query)->first();
        $this->isCompleted = $studentAttempt->is_completed ?? false;
        $this->quizRecord = $quiz;
        $this->questionCount = $quiz->quiz_questions_count;
        $studentTestQuestionsAttempt = $this->studentTestQuestionsAttempt();
        if ($studentTestQuestionsAttempt->count() > 0) {
            $this->currentIndex = $studentTestQuestionsAttempt->count();
        }
        $this->currentQuestion = $this->quizRecord->quizQuestions->get($this->currentIndex)->question ?? null;

        $this->resultPercentage = $studentAttempt->percentage_with_symbol ?? 0;
        $this->correctAnswerCount = $studentAttempt->correct_ans ?? 0;
        $this->wrongAnswerCount = $studentAttempt->wrong_ans ?? 0;
        $this->testAttemptedDate = $studentAttempt->created_at_human ?? '';
        $this->testStarted = $studentAttempt->test_started ?? false;
        // dd($studentAttempt->is_completed);
        $this->isCompleted = $studentAttempt->is_completed ?? false;
        [$this->durationMinutesForResultCard] = $this->convertToMinutesAndSeconds($quiz->duration);
        [$this->durationMinutes, $this->durationSeconds] = $this->convertToMinutesAndSeconds($studentAttempt->test_timer ?? $quiz->duration);
        $this->latestTestAttemptRecord = (clone $query)->latest()->first();

        $this->loadIncorrectAnswers($studentTestQuestionsAttempt);
    }
    private function studentTestQuestionsAttempt()
    {
        $studentTestQuestionsAttemptRecords = StudentTestQuestionAttempt::whereHas('studentTestAttempt', function ($query) {
            $query->where('student_id', Auth::id())
                ->where('quiz_id', $this->quizId);
        })
            ->with(['question:id,question'])
            ->get();
        return $studentTestQuestionsAttemptRecords;
    }
    private function loadIncorrectAnswers($getresultModalData)
    {
        $incorrectAnswers = $getresultModalData->filter(function ($item) {
            return $item->chosen_option !== $item->correct_answer;
        });
        $this->showIncorrectAnswersOnly = $incorrectAnswers;
        $this->resultModalData = $incorrectAnswers;
    }
}
