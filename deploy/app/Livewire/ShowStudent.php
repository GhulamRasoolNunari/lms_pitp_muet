<?php

namespace App\Livewire;

use App\Imports\StudentsImport;
use App\Models\Batch;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\EnrollStudent;
use App\Models\EnrollStudentDetail;
use App\Models\Phase;
use App\Models\StudentRegister;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ShowStudent extends Component
{
    use WithPagination;

    protected $listeners = ['view_student'];

    public $full_name;

    public $father_name;

    public $gender;

    public $cnic_number;

    public $contact_number;

    public $domicile_category;

    public $most_recent_institution;

    public $highest_qualification;

    public $have_disability;

    public $monthly_household_income;

    public $participated_previously;

    public $from_source;

    public $course_if_participated;

    public $phase_if_participated;

    public $center_if_participated;

    public $date_of_birth;

    public $profile_picture;

    public $intermediate_marksheet;

    public $domicile_form_c;

    public $domicile_district;

    public $is_enrolled;

    public $university_name;

    public $enrolled_status;

    public $preferred_study_center;

    public $preferred_time_slot;

    public $course_choice_1;

    public $course_choice_2;

    public $course_choice_3;

    public $course_choice_4;

    public $search = '';

    public $phases = [];

    public $phase_id;

    public $filter_course = '';

    public $filter_qualification = '';

    public $filter_gender = '';

    public $filter_d_category = '';

    public $filter_district = '';

    public $filter_study_center = '';

    public $filter_timeslot = '';

    public $campus_id;

    public $batch_id;

    public $course_id;

    public $student_id;

    public $time_slot_id;

    public $campuses = [];

    public $timeSlots = [];

    public $batches = [];

    public $courses = [];

    public function updating($name, $value)
    {
        if (in_array($name, [
            'search',
            'filter_course',
            'filter_qualification',
            'filter_gender',
            'filter_d_category',
        ])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $students = StudentRegister::query()

            // existing search
            ->when($this->search !== '', function ($q) {
                $term = "%{$this->search}%";
                $q->where(function ($q) use ($term) {
                    $q->where('full_name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('cnic_number', 'like', $term)
                        ->orWhere('contact_number', 'like', $term);
                });
            })

            // course filter (matches any course_choice_* column)
            ->when($this->filter_course !== '', function ($q) {
                $course = $this->filter_course;
                $q->where(function ($q) use ($course) {
                    $q->where('course_choice_1', $course)
                        ->orWhere('course_choice_2', $course)
                        ->orWhere('course_choice_3', $course)
                        ->orWhere('course_choice_4', $course);
                });
            })

            // highest qualification
            ->when(
                $this->filter_qualification !== '',
                fn ($q) => $q->where('highest_qualification', $this->filter_qualification)
            )
            // timeslot
            ->when(
                $this->filter_timeslot !== '',
                fn ($q) => $q->where('preferred_time_slot', $this->filter_timeslot)
            )

            // gender
            ->when(
                $this->filter_gender !== '',
                fn ($q) => $q->where('gender', $this->filter_gender)
            )

            // domicile category
            ->when(
                $this->filter_d_category !== '',
                fn ($q) => $q->where('domicile_category', $this->filter_d_category)
            )
            ->when(
                $this->filter_district !== '',
                fn ($q) => $q->where('domicile_district', $this->filter_district)
            )
            ->when(
                $this->filter_study_center !== '',
                fn ($q) => $q->where('preferred_study_center', $this->filter_study_center)
            )

            ->orderByDesc('id')
            ->paginate(10);

        $phases = Phase::all();

        return view('livewire.show-student', compact('students', 'phases'));
    }

    public function view_student($id)
    {
        $student = StudentRegister::find($id);
        $this->full_name = $student->full_name;
        $this->father_name = $student->father_name;
        $this->gender = $student->gender;
        $this->cnic_number = $student->cnic_number;
        $this->contact_number = $student->contact_number;
        $this->date_of_birth = $student->date_of_birth;
        $this->domicile_category = $student->domicile_category;
        $this->profile_picture = $student->profile_picture;
        $this->intermediate_marksheet = $student->intermediate_marksheet;
        $this->domicile_form_c = $student->domicile_form_c;
        $this->domicile_district = $student->domicile_district;
        $this->most_recent_institution = $student->most_recent_institution;
        $this->is_enrolled = $student->is_enrolled;
        $this->university_name = $student->university_name;
        $this->preferred_study_center = $student->preferred_study_center;
        $this->preferred_time_slot = $student->preferred_time_slot;
        $this->course_choice_1 = $student->course_choice_1;
        $this->course_choice_2 = $student->course_choice_2;
        $this->course_choice_3 = $student->course_choice_3;
        $this->course_choice_4 = $student->course_choice_4;
        $this->highest_qualification = $student->highest_qualification;
        $this->have_disability = $student->have_disability;
        $this->monthly_household_income = $student->monthly_household_income;
        $this->participated_previously = $student->participated_previously;
        $this->course_if_participated = $student->course_if_participated;
        $this->phase_if_participated = $student->phase_if_participated;
        $this->center_if_participated = $student->center_if_participated;
        $this->from_source = $student->from_source;

        $this->dispatch('open-task-view-modal');
    }

    public function updatedPhaseId($value)
    {
        $this->campuses = Campus::whereHas('courseDesignWiseCampus', function ($q) use ($value) {
            $q->where('phase_id', $value);
        })
            ->get();
        $this->campus_id = null;
        $this->batches = [];
        $this->batch_id = null;
        $this->courses = [];
        $this->course_id = null;
    }

    public function updatedCampusId($value)
    {
        $this->batches = Batch::whereHas('courseDesignWiseBatch', function ($q) use ($value) {
            $q->where('campus_id', $value);
        })->where('status', 1)->get();
        $this->batch_id = null;
        $this->courses = [];
        $this->course_id = null;
    }

    public function updatedBatchId($value)
    {
        $this->courses = CourseDetail::where(
            'batch_id', $value
        )->get();
        $this->course_id = null;
    }

    public function updatedCourseId($value)
    {
        $this->timeSlots = TimeSlot::where('status', 1)->get();
    }

    public function enroll_student($id)
    {
        $this->reset(['campus_id', 'batch_id', 'course_id', 'batches', 'courses']);
        $this->reset();
        $this->phases = Phase::get();
        $student = StudentRegister::find($id);
        $this->full_name = $student->full_name;
        $this->father_name = $student->father_name;
        $this->cnic_number = $student->cnic_number;
        $this->student_id = $student->id;
        $this->dispatch('open-enrol-view-modal');
    }

    public function enrollStudent($id)
    {
        $rules = [
            'phase_id' => 'required',
            'campus_id' => 'required',
            'batch_id' => 'required',
            'course_id' => 'required',
        ];
        $message = [
            'phase_id.required' => 'Phase field is required.',
            'campus_id.required' => 'Batch field is required.',
            'batch_id.required' => 'Campus field is required.',
            'course_id.required' => 'Course field is required.',
        ];

        $validated = $this->validate($rules, $message);
        $student = StudentRegister::findOrFail($id);
        $course_detail = CourseDetail::find($validated['course_id']);

        // Note: swapping ids because relations are correct now so make batch_id = campus_id and campus_id = batch_id because from frontend they are inverse for now
        try {
            DB::transaction(function () use ($student, $course_detail) {
                // logic is  set according to 1 student per course
                // 1) Capacity check: count only ACTIVE enrollments
                $currentCount = EnrollStudentDetail::query()
                    ->where('course_id', $course_detail->course_id)
                    ->where('campus_id',$course_detail->campus_id)
                    ->where('batch_id',$course_detail->batch_id)
                    ->where('time_slot_id',$course_detail->time_slot_id)
                    ->join('enroll_students', 'enroll_students.student_id', '=', 'enroll_student_details.student_id')
                    ->where('enroll_students.cancel_enrollment', 0)
                    ->join('student_registers', 'student_registers.cnic_number', '=', 'enroll_students.cnic_number')
                    ->where('student_registers.enrolled_status', 1) // filter only not cancelled
                    ->lockForUpdate()
                    ->count();

                if ($currentCount >= $course_detail->enroll_limit ?? 50) {
                    throw new \RuntimeException('This course already has ' . ($course_detail->enroll_limit ?? 50) . ' students enrolled.');
                }

                // 2) Reuse or create the auth user
                $user = User::firstOrCreate(
                    ['email' => $student->email],
                    [
                        'full_name' => $student->full_name,
                        'phone' => $student->contact_number,
                        'password' => bcrypt($student->cnic_number), // CNIC as password
                        'is_active' => '1',
                        'user_type' => 'student',
                    ]
                );

                // 3) Reuse or create the enrollment profile (global per student)
                $profile = EnrollStudent::firstOrNew(['student_id' => $user->id]);
                // If it's a new profile OR you want to refresh fields from register:
                $profile->father_name = $student->father_name;
                $profile->gender = $student->gender;
                $profile->cnic_number = $student->cnic_number;
                $profile->contact_number = $student->contact_number;
                $profile->date_of_birth = $student->date_of_birth;
                $profile->profile_picture = $student->profile_picture;
                $profile->intermediate_marksheet = $student->intermediate_marksheet;
                $profile->domicile_form_c = $student->domicile_form_c;
                $profile->domicile_district = $student->domicile_district;
                $profile->university_name = $student->university_name;

                // If previously canceled, flip back to active
                $profile->cancel_enrollment = 0;
                $profile->save();

                // 4) Course detail for THIS course
                $detail = EnrollStudentDetail::where([
                    'student_id' => $user->id,
                    // 'course_id' => $this->course_id,
                ])->lockForUpdate()->first();
                if ($detail) {
                    // If we reached here, profile is active now; update placement if needed
                    $detail->update([
                        'campus_id' => $course_detail->campus_id,
                        'batch_id' => $course_detail->batch_id,
                        'course_id' => $course_detail->course_id,
                        'time_slot_id' => $course_detail->time_slot_id,
                        'course_detail_id' => $course_detail->id,
                    ]);

                } else {
                    // No row for this course → create new detail
                    $detail = EnrollStudentDetail::create([
                        'student_id' => $user->id,
                        'campus_id' => $course_detail->campus_id,
                        'batch_id' => $course_detail->batch_id,
                        'course_id' => $course_detail->course_id,
                        'time_slot_id' => $course_detail->time_slot_id,
                        'course_detail_id' => $course_detail->id,

                    ]);
                }
                // delete any other rows for this student except the current one
                EnrollStudentDetail::where('student_id', $user->id)
                    ->where('id', '!=', $detail->id)
                    ->delete();
                // mark student as enrolled
                $student->enrolled_status = 1;
                $student->save();
            });

            $this->dispatch('close-enrol-view-modal');
            $this->dispatch(
                'student-saved',
                title: 'Success!',
                text: 'User Enrolled Successfully.',
                icon: 'success',
            );

        } catch (\RuntimeException $e) {
            $this->dispatch(
                'student-saved',
                title: 'Enrollment blocked',
                text: $e->getMessage(),
                icon: 'error',
            );
        } catch (\Throwable $e) {
            report($e);
            $this->dispatch(
                'student-saved',
                title: 'Error',
                text: 'Something went wrong while enrolling the student.',
                icon: 'error',
            );
        }
    }

    public function export()
    {
        return (new \App\Exports\StudentsExport(
            search: $this->search ?? '',
            course: $this->filter_course ?? '',
            qualification: $this->filter_qualification ?? '',
            gender: $this->filter_gender ?? '',
            dCategory: $this->filter_d_category ?? '',
            campusId: $this->campus_id ?? null,
            batchId: $this->batch_id ?? null,
            courseId: $this->course_id ?? null,
        ))->download('students.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new StudentsImport, $request->file('file'));
        $message = 'Import Has Successfully.';

        $this->dispatch(
            'student-saved',
            title: 'Success!',
            text: $message,
            icon: 'success',
        );
        sleep(1);

        return redirect()->route('show_students');
    }
}
