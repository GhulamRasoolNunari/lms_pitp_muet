<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\EnrollStudent as EnrollStudentModel;
use App\Models\EnrollStudentDetail;
use App\Models\StudentRegister;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class EnrollStudent extends Component
{
    use WithPagination;

    public $full_name;

    public $father_name;

    public $gender;

    public $email;

    public $cnic_number;

    public $phone;

    public $contact_number;

    public $date_of_birth;

    public $highest_qualification;

    public $most_recent_institution;

    public $profile_picture;

    public $intermediate_marksheet;

    public $domicile_form_c;

    public $domicile_category;

    public $preferred_study_center;

    public $preferred_time_slot;

    public $domicile_district;

    public $university_name;

    public $search = '';

    public $enrolledDetails = [];

    public $campuses = [];

    public $batches = [];

    public $timeSlots = [];

    public $course_details = [];

    public $course_detail_ids = [];

    public $courses = [];

    public $student_id;

    public $time_slot_ids = [];

    public $campus_ids = [];

    public $batch_ids = [];

    public $course_ids = [];

    public $student_details = [];

    public array $districts = [];

    public $filter_course = '';

    public $filter_qualification = '';

    public $filter_gender = '';

    public $filter_d_category = '';

    public $filter_district = '';

    public $filter_study_center = '';

    public $filter_enrolled_in_campus = '';

    public $filter_enrolled_in_batch = '';

    public $filter_enrolled_in_course = '';
    public $filter_enrolled_in_time_slot = '';
    public $filter_enrolled_in_course_details = '';

    public $filter_timeslot = '';

    public $overAllBatches = [];
    public $courseDetails = [];

    public $overAllCampus = [];

    public $overAllCourse = [];
    public $overAllTimeSlots = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->campuses = Campus::get();
        // $this->timeSlots=TimeSlot::get();
        $this->districts = config('filters.districts');
        $this->overAllBatches = Campus::all();
        $this->overAllCampus = Batch::all();
        $this->overAllCourse = Course::all();
        $this->overAllTimeSlots = TimeSlot::all();
        $this->courseDetails = CourseDetail::all();

    }

    public function render()
    {
        $students = User::with(['student_detail'])->where('user_type', 'student')
            ->whereHas('student_detail', function ($q) {
                $q->where('cancel_enrollment', 0);
            })
            ->whereHas('student_detail.registered_student', function ($q) {
                // course filter matches any of the 4 choices
                $q->when($this->filter_course !== '', function ($qq) {
                    $c = $this->filter_course;
                    $qq->where(function ($qx) use ($c) {
                        $qx->where('course_choice_1', $c)
                            ->orWhere('course_choice_2', $c)
                            ->orWhere('course_choice_3', $c)
                            ->orWhere('course_choice_4', $c);
                    });
                });

                // highest qualification
                $q->when($this->filter_qualification !== '',
                    fn ($qq) => $qq->where('highest_qualification', $this->filter_qualification)
                );

                // gender
                $q->when($this->filter_gender !== '',
                    fn ($qq) => $qq->where('gender', $this->filter_gender)
                );

                // domicile category
                $q->when($this->filter_d_category !== '',
                    fn ($qq) => $qq->where('domicile_category', $this->filter_d_category)
                );

                // district
                $q->when($this->filter_district !== '',
                    fn ($qq) => $qq->where('domicile_district', $this->filter_district)
                );

                // preferred study center
                $q->when($this->filter_study_center !== '',
                    fn ($qq) => $qq->where('preferred_study_center', $this->filter_study_center)
                );
                // preferred study center
                $q->when($this->filter_timeslot !== '',
                    fn ($qq) => $qq->where('preferred_time_slot', $this->filter_timeslot)
                );
            })
            ->whereHas('enroll_detail', function ($q) {
                $q->when($this->filter_enrolled_in_batch !== '',
                    fn ($qq) => $qq->where('campus_id', $this->filter_enrolled_in_batch)
                );
                $q->when($this->filter_enrolled_in_campus !== '',
                    fn ($qq) => $qq->where('batch_id', $this->filter_enrolled_in_campus)
                );
                $q->when($this->filter_enrolled_in_course !== '',
                    fn ($qq) => $qq->where('course_id', $this->filter_enrolled_in_course)
                );
                $q->when($this->filter_enrolled_in_time_slot !== '',
                    fn ($qq) => $qq->where('time_slot_id', $this->filter_enrolled_in_time_slot)
                );
                $q->when($this->filter_enrolled_in_course_details !== '',
                    fn ($qq) => $qq->where('course_detail_id', $this->filter_enrolled_in_course_details)
                );
            })

            ->where('is_active', '1')
            ->where(function ($query) {
                $query->where('full_name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhereRelation('student_detail', 'cnic_number', 'like', '%'.$this->search.'%')
                    ->orWhereRelation('student_detail', 'contact_number', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(50);

        return view('livewire.enroll-student', compact('students'));
    }

    public function updatedCampusIds($value, $index)
    {
        $this->campus_ids[$index] = $value ? (int) $value : null;
        $this->batch_ids[$index] = null;
        $this->course_ids[$index] = null;
        $this->batches[$index] = collect();
        $this->courses[$index] = collect();
        $this->course_details[$index] = collect();

        if ($value) {
            $this->batches[$index] =
            Batch::whereHas('courseDesignWiseBatch', function ($q) use ($value) {
                $q->where('campus_id', (int) $value);
            })->where('status', 1)->get();
        }
    }

    public function updatedBatchIds($value, $index)
    {
        $this->batch_ids[$index] = $value ? (int) $value : null;
        $this->course_ids[$index] = null;
        $this->course_detail_ids[$index] = null;
        $this->time_slot_ids[$index] = null;
        $this->courses[$index] = collect();
        $this->course_details[$index] = collect();
        $this->timeSlots[$index] = collect();

        if ($value) {
            $this->timeSlots[$index] = TimeSlot::whereHas('timeSlotDesignWiseCourses', function ($q) use ($value) {
                $q->where('batch_id', $value);
            })->get();
            $this->course_details[$index] = CourseDetail::where('batch_id', $value)->get();
            $this->courses[$index] = Course::whereHas('courseDesignWiseCourses', function ($q) use ($value) {
                $q->where('batch_id', $value);
            })->get();
        }
    }

    // public function updatedCourseIds($value, $index)
    // {
    //     $this->course_ids[$index] = $value ? (int) $value : null;
    //     // $this->timeSlots[$index] = TimeSlot::where('status', 1)->get();
    // }

    public function view_student($id)
    {
        $student = EnrollStudentModel::with([
            'enroll_student.campus',
            'enroll_student.batch',
            'enroll_student.course',
        ])->where('student_id', $id)->first();
        $this->full_name = $student->student->full_name;
        $this->father_name = $student->father_name;
        $this->gender = $student->gender;
        $this->cnic_number = $student->cnic_number;
        $this->contact_number = $student->contact_number;
        $this->date_of_birth = $student->date_of_birth;
        $this->profile_picture = $student->profile_picture;
        $this->intermediate_marksheet = $student->intermediate_marksheet;
        $this->domicile_form_c = $student->domicile_form_c;
        $this->domicile_district = $student->domicile_district;
        $this->university_name = $student->university_name;

        $this->enrolledDetails = $student->enroll_student;

        $this->dispatch('open-task-view-modal');
    }

    public function enroll_student($id)
    {
        $this->reset(['campus_ids', 'batch_ids', 'course_ids', 'batches', 'courses', 'full_name', 'father_name', 'cnic_number', 'student_id']);

        $student_data = EnrollStudentModel::with('student')->where('student_id', $id)->first();
        $student_register_data = StudentRegister::where('cnic_number', $student_data->cnic_number)->first();
        // dd($student_register_data);

        $this->student_details = EnrollStudentDetail::where('student_id', $id)->get()->toArray();
        // dd($this->student_details);
        if ($student_data) {
            $this->full_name = $student_data->student->full_name;
            $this->father_name = $student_data->father_name;
            $this->gender = Str::lcfirst($student_data->gender);
            $this->date_of_birth = $student_data->date_of_birth;
            $this->cnic_number = $student_data->cnic_number;
            $this->email = $student_data->student->email;
            $this->phone = $student_data->contact_number;
            $this->highest_qualification = $student_register_data->highest_qualification;
            $this->most_recent_institution = $student_register_data->most_recent_institution;
            $this->domicile_district = $student_register_data->domicile_district;
            $this->domicile_category = $student_register_data->domicile_category;
            $this->preferred_study_center = $student_register_data->preferred_study_center;
            $this->preferred_time_slot = $student_register_data->preferred_time_slot;
            $this->student_id = $student_data->student_id;
        }
        foreach ($this->student_details as $index => $detail) {
            $this->campus_ids[$index] = $detail['campus_id'];
            $this->batch_ids[$index] = $detail['batch_id'];
            $this->course_ids[$index] = (int) $detail['course_id'];
            $this->course_detail_ids[$index] = (int) $detail['course_detail_id'];
            $this->time_slot_ids[$index] = $detail['time_slot_id'];

            // Populate batches for this campus_id
            $this->batches[$index] = $this->campus_ids[$index]
            ? Batch::whereHas('courseDesignWiseBatch', function ($q) use ($index) {
                $q->where('campus_id', $this->campus_ids[$index]);
            })->where('status', 1)->get()
            : collect();
            $this->timeSlots[$index] = $this->time_slot_ids[$index]
            ? TimeSlot::where('status', 1)
                ->get()
            : collect();

            $this->courses[$index] = $this->batch_ids[$index]
            ? Course::whereHas('courseDesignWiseCourses', function ($q) use ($index) {
                $q->where('batch_id', $this->batch_ids[$index]);
            })->get()
            : collect();
            $this->course_details[$index] = $this->batch_ids[$index]
            ? CourseDetail::where('batch_id', $this->batch_ids[$index])->get()
            : collect();
            //    dd($this->courses[$index]);
        }
        //         logger()->debug('CourseDetail IDs', $this->courses[$index]->pluck('id')->all());
        // logger()->debug('Selected detail id', [$this->course_ids[$index]]);
        $this->dispatch('open-enrol-view-modal');
    }
    // public function updateStudents()
    // {

    //     try {

    //         $this->validate([
    //             'campus_ids.*' => 'required|exists:campuses,id',
    //             'batch_ids.*' => 'nullable|exists:batches,id',
    //             'course_ids.*' => 'nullable|exists:courses,id',
    //         ]);

    //         // dd($this->student_id);
    //         // Process each campus_id
    //         foreach ($this->campus_ids as $index => $campus_id) {
    //             if (!empty($campus_id)) {
    //                 // Cast all IDs to integers
    //                 $campus_id = (int) $campus_id;
    //                 $batch_id = isset($this->batch_ids[$index]) ? (int) $this->batch_ids[$index] : null;
    //                 $course_id = isset($this->course_ids[$index]) ? (int) $this->course_ids[$index] : null;

    //                 // Find existing enrollment by student_id and campus_id
    //                 $enrollDetail = EnrollStudentDetail::where('student_id', (int) $this->student_id)
    //                     ->where('campus_id', $campus_id)
    //                     ->first();

    //                 if ($enrollDetail) {
    //                     // Update existing record
    //                     $enrollDetail->update([
    //                         'campus_id' => $campus_id,
    //                         'batch_id' => $batch_id,
    //                         'course_id' => $course_id,
    //                     ]);
    //                 }
    //             }
    //         }
    //         // Dispatch success events
    //         $this->dispatch('close-enrol-view-modal');
    //         $this->dispatch(
    //             'student-update',
    //             title: 'Success!',
    //             text: 'User Course Updated.',
    //             icon: 'success',
    //         );
    //     } catch (\Exception $e) {
    //         \Log::error('Error updating student enrollment: ' . $e->getMessage());
    //         $this->dispatch(
    //             'student-update',
    //             title: 'Error!',
    //             text: 'An error occurred while updating enrollment.',
    //             icon: 'error',
    //         );
    //     }
    // }

    public function cancelEnrollment(array $ids)
    {
        // sanitize
        $ids = array_values(array_unique(array_map('intval', $ids)));
        if (empty($ids)) {
            $this->dispatch('student-update', icon: 'error', text: 'No selection.');

            return;
        }

        DB::transaction(function () use ($ids) {
            // 1) Mark enrollments as canceled
            EnrollStudentModel::whereIn('student_id', $ids)
                ->update(['cancel_enrollment' => 1]);

            // 2) Grab CNICs for those students (distinct, non-null)
            $cnics = EnrollStudentModel::whereIn('student_id', $ids)
                ->pluck('cnic_number')
                ->filter()
                ->unique()
                ->values();

            if ($cnics->isNotEmpty()) {
                // 3) Reset enrolled_status in student_registers for matching CNICs
                StudentRegister::whereIn('cnic_number', $cnics)
                    ->update(['enrolled_status' => 0]);
            }
        });

        // toast
        $this->dispatch('student-update', [
            'icon' => 'success',
            'text' => 'Enrollment(s) canceled successfully!',
        ]);

        // optional: refresh table/pagination
        // $this->resetPage();
        // $this->dispatch('$refresh');
    }

    public function export()
    {

        return (new \App\Exports\EnrollStudentExport)->download('enroll_students.xlsx');
    }

    public function updateStudent()
    {
        // $this->validate([
        //     // form fields you showed
        //     'full_name' => 'required|string|max:255',
        //     'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->student_id)],
        //     'phone' => 'required|string|max:20',
        //     'father_name' => 'required|string|max:255',
        //     'gender' => 'required|in:male,female,transgender',
        //     'cnic_number' => 'required|string|max:13',
        //     'date_of_birth' => 'required|date',
        //     'domicile_district' => 'required|string|max:255',
        //     'most_recent_institution' => 'required|string|max:255',
        //     'highest_qualification' => 'required|string|max:100',
        //     'preferred_study_center' => 'required|string|max:255',
        //     'preferred_time_slot' => 'required|string|max:255',

        //     // detail arrays
        //     'campus_ids.*' => 'required|exists:campuses,id',
        //     'time_slot_ids.*' => 'required|exists:time_slots,id',
        //     'batch_ids.*' => 'required|exists:batches,id',
        //     'course_ids.*' => 'required|exists:course_details,id',
        // ]);
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->student_id)],
            'phone' => 'required|string|max:20',
            'father_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,transgender',
            'cnic_number' => 'required|string|max:13',
            'date_of_birth' => 'required|date',
            'domicile_district' => 'required|string|max:255',
            'most_recent_institution' => 'required|string|max:255',
            'highest_qualification' => 'required|string|max:100',
            'preferred_study_center' => 'required|string|max:255',
            'preferred_time_slot' => 'required|string|max:255',

            // detail arrays
            'campus_ids.*' => 'required|exists:campuses,id',
            // 'time_slot_ids.*' => 'required|exists:time_slots,id',
            'batch_ids.*' => 'required|exists:batches,id',
            'course_ids.*' => 'required|exists:courses,id',
            'course_detail_ids.*' => 'required|exists:course_details,id',
        ];
        $message = [
            'campus_ids*.required' => 'Campus field is required.',
            'batch_ids.*.required' => 'Batch field is required.',
            // 'time_slot_ids.*required' => 'Campus field is required.',
            'course_ids.*required' => 'Course ID field is required.',
            'course_detail_ids.*required' => 'Designed Course Field is required.',
        ];

        $validated = $this->validate($rules, $message);
        $course_detail = CourseDetail::find($validated['course_detail_ids'][0]);
        try {
            DB::transaction(function () use ($course_detail) {
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

                // dd($currentCount);
                if ($currentCount >= $course_detail->enroll_limit ?? 50) {
                    throw new \RuntimeException( 'This course already has ' . ($course_detail->enroll_limit ?? 50) . ' students enrolled.');
                }
                // --- 1) Load profile by current user/student id
                $profile = EnrollStudentModel::with('student')
                    ->where('student_id', (int) $this->student_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // --- 2) Resolve StudentRegister by the *current* profile CNIC
                // (so you can safely change CNIC in this update)
                $register = StudentRegister::where('cnic_number', $profile->cnic_number)
                    ->latest('id')
                    ->lockForUpdate()
                    ->first();

                // --- 3) Update USER
                $profile->student->fill([
                    'full_name' => $this->full_name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                ])->save();

                // --- 4) Update ENROLL_STUDENTS (profile sheet)
                $profile->fill([
                    'father_name' => $this->father_name,
                    'gender' => $this->gender,
                    'cnic_number' => $this->cnic_number,     // can change
                    'contact_number' => $this->phone,
                    'date_of_birth' => $this->date_of_birth,
                    'domicile_district' => $this->domicile_district,
                    'university_name' => $this->most_recent_institution,
                    // add picture/marksheet/etc if you collect them
                ])->save();

                // --- 5) Update STUDENT_REGISTERS (application card), if found via CNIC
                if ($register) {
                    $register->fill([
                        'full_name' => $this->full_name,
                        'father_name' => $this->father_name,
                        'gender' => $this->gender,
                        'cnic_number' => $this->cnic_number, // keep in sync
                        'email' => $this->email,
                        'contact_number' => $this->phone,
                        'date_of_birth' => $this->date_of_birth,
                        'domicile_district' => $this->domicile_district,
                        'most_recent_institution' => $this->most_recent_institution,
                        'highest_qualification' => $this->highest_qualification,
                        'preferred_study_center' => $this->preferred_study_center,
                        'preferred_time_slot' => $this->preferred_time_slot,
                    ])->save();
                }
                // If you want to create when missing, you can add a create() here.

                // --- 6) Update per-campus/batch/course details (existing rows only)
                if (is_array($this->campus_ids)) {
                    foreach ($this->campus_ids as $i => $campus_id) {
                        if (empty($campus_id)) {
                            continue;
                        }

                        $campus_id = (int) $campus_id;
                        // $batch_id = ! empty($this->batch_ids[$i]) ? (int) $this->batch_ids[$i] : null;
                        // $course_id = ! empty($this->course_ids[$i]) ? (int) $this->course_ids[$i] : null;
                        // $time_slot_id = ! empty($this->time_slot_ids[$i]) ? (int) $this->time_slot_ids[$i] : null;

                        $detail = EnrollStudentDetail::where('student_id', $profile->student_id)
                            ->lockForUpdate()
                            ->first();

                        if ($detail) {
                            $detail->update([
                                'campus_id' => $course_detail->campus_id,
                                'batch_id' => $course_detail->batch_id,
                                'course_id' => $course_detail->course_id,
                                'time_slot_id' => $course_detail->time_slot_id,
                                'course_detail_id' => $course_detail->id,
                            ]);
                        }
                    }
                }
            });

            $this->dispatch('close-enrol-view-modal');
            $this->dispatch('student-update', title: 'Success!', text: 'User profile & enrollment updated.', icon: 'success');
        } catch (\Throwable $e) {
            report($e);
            $this->dispatch(
                'student-update',
                title: 'Error!',
                text: $e->getMessage(), // show exception message
                icon: 'error'
            );
        }
    }
}
