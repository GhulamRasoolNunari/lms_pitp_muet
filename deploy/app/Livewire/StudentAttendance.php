<?php

namespace App\Livewire;

use App\Models\CourseDetail;
use App\Models\EnrollStudentDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\StudentAttendace as AttendanceModel;

class StudentAttendance extends Component
{
    public $students = [];
    public $attendances = [];
    public $attendanceDate, $course_id = null;

    public function mount()
    {
        $this->attendanceDate = now()->format('Y-m-d');
        $this->loadStudents();
    }

    public function loadStudents()
    {

   if ($this->course_id != null) {
            $courseDetail = CourseDetail::where('user_id', auth()->id())->get();
            $course = collect($courseDetail)->where('id', $this->course_id)->first();

            // Fetch the students and map them to include attendance data
            $this->students = EnrollStudentDetail::with('student.student')
                ->where([
                    'campus_id' => $course->campus_id,
                    'batch_id' => $course->batch_id,
                    'course_id' => $course->course_id,
                ])
                ->get()
                ->map(function($item) {
                    // If the student is null, return null to exclude it
                    if ($item->student == null) {
                        return null;
                    }

                    // Get the student
                    $enrolledStudent = $item->student->student;

                    // Get the attendance for the student on the given date
                    $attendance = AttendanceModel::where('student_id', $enrolledStudent->id)
                        ->whereDate('date', $this->attendanceDate)
                        ->first();

                    // Add the attendance status as a new attribute
                     $val = is_null($attendance) ? null : ($attendance->is_present ? 'present' : 'absent');
                    $enrolledStudent->attendance_status = $val;
                    // Also, populate the $this->attendances array
                     $this->attendances[$enrolledStudent->id] = $val;

                    return $enrolledStudent;
                })
                ->filter();  // Remove null values (students without attendance or invalid students)

        }

    }

    public function updatedAttendanceDate()
    {
        $this->loadStudents();
    }

    public function saveAttendance()
    {
        foreach ($this->attendances as $studentId => $status) {
            $status = $status === "present" ? "1" : "0";
            AttendanceModel::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $this->attendanceDate,
                ],
                [
                    'is_present' => $status, // status can be: present, absent, leave
                ]
            );
        }
        $this->attendances = [];

        $this->reset();

        // Alert
        $this->dispatch(
            'attendace-saved',
            title: 'Success!',
            text: 'Attendance has been saved successfully.',
            icon: 'success',
        );

        // sleep(1);

        // return redirect()->route('teacher.attendace');
    }
    public function markAll($status)
    {
        foreach ($this->students as $student) {
            $this->attendances[$student->id] = $status;
        }
    }
    public function updatedCourseId($value)
    {
        $this->course_id = $value;
        $this->loadStudents();
    }
    public function render()
    {
        // $courses = Auth::user()->courses()->with('batch')->get();
        $courses = CourseDetail::with(['user', 'course', 'campus', 'batch', 'time_slot'])
        ->where('user_id', auth()->id())
        ->get();

        return view('livewire.student-attendance', compact('courses'));
    }
}
