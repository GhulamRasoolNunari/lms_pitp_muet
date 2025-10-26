<?php

use App\Http\Controllers\LoginController;
use App\Livewire\Batch;
use App\Livewire\Campus;
use App\Livewire\CourseCampus;
use App\Livewire\CreateCourses;
use App\Livewire\CreateNewCourse;
use App\Livewire\Dashboard;
use App\Livewire\EditProfile;
use App\Livewire\EnrollStudent;
use App\Livewire\Phase;
use App\Livewire\ProgrammeCreate;
use App\Livewire\Question;
use App\Livewire\Quiz;
use App\Livewire\QuizStudent;
use App\Livewire\ShowStudent;
use App\Livewire\StartTest;
use App\Livewire\Student;
use App\Livewire\StudentAttendance;
use App\Livewire\StudentTask;
use App\Livewire\StudentTaskUplode;
use App\Livewire\StudentView;
use App\Livewire\Teacher;
use App\Livewire\TeacherTask;
use App\Livewire\TimeSlot;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

// Livewire::setUpdateRoute(function ($handle) {
//     return Route::post('/gexton-lms-mehran/public/livewire/update', $handle);
// });

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::middleware(['restrict_admin'])->group(function () {
            Route::get('/profile', EditProfile::class)->name('show_profile');
            Route::get('/show-phases', Phase::class)->name('show_phase');
            // Route::get('/show-programmes', ProgrammeCreate::class)->name('show_programme');
            Route::get('/show-batches', Campus::class)->name('show_campus');
            Route::get('/show-campus', Batch::class)->name('show_batches');
            // Route::get('/course-campus', CourseCampus::class)->name('course_campus');
            Route::get('time-slot', TimeSlot::class)->name('time_slot');
            Route::get('create-course', CreateNewCourse::class)->name('courses_new_course');
            Route::get('assign-course-to-teacher', CreateCourses::class)->name('courses_create');
            Route::get('registered-student', ShowStudent::class)->name('show_students');
            Route::get('enroll-student', EnrollStudent::class)->name('enroll_students');
            Route::get('/students/enroll-export', [EnrollStudent::class, 'export'])->name('enroll_students.export');
            Route::get('create-trainer', Teacher::class)->name('create_teacher');
            Route::get('/students/export', [ShowStudent::class, 'export'])->name('students.export');
            Route::post('/students/import', [ShowStudent::class, 'import'])->name('students.import');
        });

    });
    Route::middleware(['role:student'])->prefix('students')->name('students.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/assignments', StudentTask::class)->name('tasks');
        Route::get('/uplode-tasks', StudentTaskUplode::class)->name('uplodetasks');
        Route::get('/show-', Question::class)->name('show_questions');
        Route::get('show-quiz', QuizStudent::class)->name('show_quiz');
        Route::get('start-test/{id}', StartTest::class)->name('start_test');

    });
    Route::middleware(['role:teacher'])->prefix('trainer')->name('teacher.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/students', StudentView::class)->name('students');
        Route::get('/attendace', StudentAttendance::class)->name('attendace');
        Route::get('/task', TeacherTask::class)->name('task');
        Route::get('/show-questions', Question::class)->name('show_questions');
        Route::get('show-quiz', Quiz::class)->name('show_quiz');
    });
    Route::get('/profile', EditProfile::class)->name('show_profile');

});
Route::get('/student-register', Student::class)->name('student_registerd');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('login_attemept', 'authenticate')
        ->middleware('throttle:5,1')
        ->name('login.attempt');
    Route::post('/logout', 'logout')->name('logout');
});
