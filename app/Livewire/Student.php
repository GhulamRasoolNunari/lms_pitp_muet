<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\StudentRegister;
use App\Rules\UniqueAcrossTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\RateLimiter;

class Student extends Component
{
    use WithFileUploads;
    public bool $info_confirm = false;

    public $full_name, $father_name, $gender, $cnic_number, $email, $contact_number, $date_of_birth, $profile_picture, $intermediate_marksheet, $domicile_district, $domicile_category, $domicile_form_c,  $most_recent_institution, $preferred_study_center, $preferred_time_slot, $course_choice_1, $course_choice_2, $course_choice_3, $course_choice_4;
    public $highest_qualification, $have_disability, $monthly_household_income, $course_if_participated, $phase_if_participated, $center_if_participated, $from_source, $participated_previously;
    public $activeTab = 'step1';
    // public string $highestQualification = '';
    public array $courseList = [];
    // course Setup
    // Master list
    protected array $allCourses = [
        'Certified Cloud Computing Professional',
        'Certified Cyber Security and Ethical Hacking Professional',
        'Certified Data Scientist',
        'Certified Database Administrator',
        'Certified Digital Marketing Professional',
        'Certified E-Commerce Professional',
        'Certified Graphic Designer',
        'Certified Java Developer',
        'Certified Mobile Application Developer',
        'Certified Python Developer',
        'Certified Social Media Manager',
        'Certified Web Developer',
    ];

    // Matric courses
    protected array $matricCourses = [
        'Certified Graphic Designer',
        'Certified Digital Marketing Professional',
        'Certified E-Commerce Professional',
        'Certified Social Media Manager',
        'Certified Web Developer',
        'Certified Python Developer',
    ];

    // Graduate courses
    protected array $graduateCourses = [
        'Certified Cloud Computing Professional',
        'Certified Cyber Security and Ethical Hacking Professional',
        'Certified Data Scientist',
        'Certified Database Administrator',
        'Certified Digital Marketing Professional',
        'Certified E-Commerce Professional',
        'Certified Graphic Designer',
        'Certified Java Developer',
        'Certified Mobile Application Developer',
        'Certified Python Developer',
        'Certified Social Media Manager',
        'Certified Web Developer',
    ];
    // districts
    public array $districts = [
        'badin'               => 'Badin',
        'dadu'                => 'Dadu',
        'ghotki'              => 'Ghotki',
        'hyderabad'           => 'Hyderabad',
        'jacobabad'           => 'Jacobabad',
        'jamshoro'            => 'Jamshoro',
        'karachi-central'     => 'Karachi Central',
        'karachi-east'        => 'Karachi East',
        'karachi-south'       => 'Karachi South',
        'karachi-west'        => 'Karachi West',
        'kashmore'            => 'Kashmore',
        'khairpur'            => 'Khairpur',
        'larkana'             => 'Larkana',
        'matiari'             => 'Matiari',
        'mirpurkhas'          => 'Mirpurkhas',
        'naushahro-feroze'    => 'Naushahro Feroze',
        'shaheed-benazirabad' => 'Shaheed Benazirabad',
        'qambar-shahdadkot'   => 'Qambar Shahdadkot',
        'sanghar'             => 'Sanghar',
        'shikarpur'           => 'Shikarpur',
        'sukkur'              => 'Sukkur',
        'tando-allahyar'      => 'Tando Allahyar',
        'tando-muhammad-khan' => 'Tando Muhammad Khan',
        'tharparkar'          => 'Tharparkar',
        'thatta'              => 'Thatta',
        'umerkot'             => 'Umerkot',
        'sujawal'             => 'Sujawal',
        'korangi'             => 'Korangi',
        'malir'               => 'Malir',
    ];
    //
    public function mount()
    {
        // Optional: set a default
        $this->highest_qualification = $this->highest_qualification ?? null;
        $this->refreshCourseList();
    }
    // from changing qualification wise to on course choices change option exclusion section = mainQualifSec
    public function updatedHighestQualification($value)
    {
        $this->highest_qualification = $value;
        $this->refreshCourseList();
        $this->reset([
            'course_choice_1',
            'course_choice_2',
            'course_choice_3',
            'course_choice_4',
        ]);
    }
    private function refreshCourseList(): void
    {
        $list = match ($this->highest_qualification) {
            'matric'        => $this->matricCourses,
            'intermediate'  => $this->allCourses,
            'graduate'      => $this->graduateCourses,
            default         => [],
        };
        $this->courseList = array_map(fn($s) => trim($s), $list);
    }
    /* === Helpers === */
    private function selectedClean(array $items): array
    {
        // keep only non-empty + trimmed
        return array_values(array_filter(array_map(
            fn($s) => $s === null ? null : trim($s),
            $items
        )));
    }

    #[Computed]
    public function availableCoursesForChoice1(): array
    {
        // dd($this->courseList);
        return $this->courseList;
    }
    #[Computed]
    public function availableCoursesForChoice2(): array
    {
        $exclude = $this->selectedClean([$this->course_choice_1]);
        return array_values(array_diff($this->courseList, $exclude));
    }

    #[Computed]
    public function availableCoursesForChoice3(): array
    {
        $exclude = $this->selectedClean([$this->course_choice_1, $this->course_choice_2]);
        return array_values(array_diff($this->courseList, $exclude));
    }

    #[Computed]
    public function availableCoursesForChoice4(): array
    {
        $exclude = $this->selectedClean([
            $this->course_choice_1,
            $this->course_choice_2,
            $this->course_choice_3
        ]);
        return array_values(array_diff($this->courseList, $exclude));
    }

    public function updatedCourseChoice1(): void
    {
        $this->reset(['course_choice_2', 'course_choice_3', 'course_choice_4']);
        $this->dispatch('$refresh'); // force DOM to reconcile
    }

    public function updatedCourseChoice2(): void
    {
        $this->reset(['course_choice_3', 'course_choice_4']);
        $this->dispatch('$refresh');
    }

    public function updatedCourseChoice3(): void
    {
        $this->reset('course_choice_4');
        $this->dispatch('$refresh');
    }
    // selected Course Ends
    // mainQualifSec End

    // When user selects "no", clear the extra fields
    public function updatedParticipatedPreviously($val): void
    {
        if ($val === 'no') {
            $this->reset(['phase_if_participated', 'course_if_participated', 'center_if_participated']);
        }
    }
    protected function rulesStep1()
    {
        return [
            'full_name' => ['required', 'string', 'min:2', 'max:150'],
            'father_name' => ['required', 'string', 'min:2', 'max:150'],
            'gender' => ['required', Rule::in(['male', 'female', 'transgender'])],
            'cnic_number'    => ['required', 'integer', 'digits:13', new UniqueAcrossTables(['student_registers'], 'cnic_number')],
            'email'  => ['required', 'email', 'max:100',   new UniqueAcrossTables(['student_registers', 'users'], 'email')],
            'contact_number' => ['required', 'digits:11'],
            'date_of_birth' => ['required', 'date'],
            'profile_picture' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:256'],
            'highest_qualification' => ['required', 'string', Rule::in(['matric', 'intermediate', 'graduate'])],
            'most_recent_institution' => ['required', 'string'],
            'intermediate_marksheet' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:256'],
            'domicile_district'       => ['required', 'string', 'max:100', Rule::in(array_keys($this->districts))],
            'domicile_category' => ['required', 'string', Rule::in(['urban', 'rural'])],
            'domicile_form_c' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:256'],
        ];
    }
    protected function rulesStep2()
    {
        return [
            'preferred_study_center' => ['required', 'string'],
            'preferred_time_slot' => ['required', 'string'],
            'course_choice_1' => ['required'],
            'course_choice_2' => ['required', 'different:course_choice_1'],
            'course_choice_3' => ['required', 'different:course_choice_1', 'different:course_choice_2'],
            'course_choice_4' => ['required', 'different:course_choice_1', 'different:course_choice_2', 'different:course_choice_3'],
        ];
    }
    protected function rulesStep3()
    {
        return [
            'have_disability' => ['required', Rule::in(['yes', 'no'])],
            'monthly_household_income' => ['required'],
            'participated_previously' => ['required', Rule::in(['yes', 'no'])],
            'course_if_participated' => ['exclude_unless:participated_previously,yes', 'required', 'string', 'max:150'],
            'phase_if_participated' => ['exclude_unless:participated_previously,yes', 'required', 'string', 'max:150'],
            'center_if_participated' => ['exclude_unless:participated_previously,yes', 'required', 'string', 'max:150'],
            'from_source'  => ['required', 'string', 'max:50', Rule::in(['socail media', 'friend/family', 'university', 'post/banner', 'whatsapp group', 'other'])],
            'info_confirm' => ['accepted'],
        ];
    }

    protected function rules()
    {
        return match ($this->activeTab) {
            'step1' => $this->rulesStep1(),
            'step2' => $this->rulesStep2(),
            'step3' => $this->rulesStep3(),
            default => [],
        };
    }
    protected $messages = [
        'info_confirm.accepted' => 'Please confirm that the information is accurate.',
        'domicile_form_c.required' => 'Please upload Domicile or Form‑C (max 256 KB).',
        'profile_picture.max'      => 'Profile picture must be at most 1 MB.',
        'profile_picture.mimes'    => 'Profile picture must be JPG or PNG.',
        // 'profile_picture.dimensions' => 'Profile picture must be passport size (~35x45mm, ratio 7:9, min 350×450 px).',
        'intermediate_marksheet.max' => 'Intermediate Marksheet/Certificate must be at most 256 KB.',
        'course_choice_2.different' => 'Course choices must be different.',
        'course_choice_3.different' => 'Course choices must be different.',
        'course_choice_4.different' => 'Course choices must be different.',
        'cnic_number.digits'       => ' must be exactly 13 digits.',
        'contact_number.digits'    => 'Contact number must be exactly 11 digits.',
        'course_if_participated.exclude_unless' => 'previous course required if you have participated before',
        'course_if_participated.required' => 'course required if you have participated before',
        'phase_if_participated.exclude_unless' => 'previous phase required if you have participated before',
        'phase_if_participated.required' => 'phase required if you have participated before',
        'center_if_participated.exclude_unless' => 'previous center required if you have participated before',
        'center_if_participated.required' => 'center required if you have participated before',
    ];

    public function render()
    {
        return view('livewire.student')->layout('layouts.student-layout');
    }
    public function switchTab($tab)
    {
        // Validate current step before moving
        if ($this->activeTab === 'step1') {
            $this->validate($this->rulesStep1());
        } elseif ($this->activeTab === 'step2' && $tab === 'step3') {
            $this->validate($this->rulesStep2());
        }

        $this->activeTab = $tab;
    }
    protected function rulesSoFar(): array
    {
        return match ($this->activeTab) {
            'step1' => $this->rulesStep1(),
            'step2' => array_merge($this->rulesStep1(), $this->rulesStep2()),
            'step3' => array_merge($this->rulesStep1(), $this->rulesStep2(), $this->rulesStep3()),
            default => [],
        };
    }
    public function save()
    {
        // Build a unique key (per IP or per user). Here: per IP.
        $key = 'student-register:' . request()->ip();
        $max = 5;          // 5 attempts
        $decay = 60;       // per 60 seconds

        // If over the limit, show an error and stop
        if (RateLimiter::tooManyAttempts($key, $max)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate', "Too many attempts. Please try again in {$seconds} seconds.");
            return;
        }

        // Count this attempt (expires after $decay seconds)
        RateLimiter::hit($key, $decay);
        $this->refreshCourseList();
        // Validate all input fields according to your rules
        $validatedData = $this->validate($this->rulesSoFar());
        // Force CNIC & contact number into string to preserve leading zeros
        $validatedData['cnic_number']    = (string) $validatedData['cnic_number'];
        $validatedData['contact_number'] = (string) $validatedData['contact_number'];

        $fileDirs = [
            'profile_picture'        => '/profile_pictures',
            'intermediate_marksheet' => '/marksheets',
            'domicile_form_c'        => '/domicile_form_c',
        ];

        foreach ($fileDirs as $field => $subFolder) {
            if ($this->$field) {
                $file     = $this->$field;
                $ext      = strtolower($file->getClientOriginalExtension());
                $filename = time() . '_' . $field . '.' . $ext;

                // Absolute path to the target folder in /public
                $destinationPath = public_path($subFolder);

                // Ensure folder exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Store file in that subfolder via custom_public disk
                $file->storeAs($subFolder, $filename, [
                    'disk' => 'custom_public',
                ]);

                // Save relative path for DB or further use
                $validatedData[$field] = "{$filename}";
            }
        }
        if ($this->activeTab === 'step3') {
            StudentRegister::create($validatedData);

            $this->reset();
            return redirect()->back()->with('message', '
                        <div class="alert alert-success"
                        style="padding:20px; line-height:1.6; font-size:15px; text-align:left;">
                    <p style="font-weight:bold; margin-bottom:10px;">Dear Candidate,</p>

                    <p style="margin-bottom:10px;">
                        Thank you for submitting your registration form for PITP Phase II. Interviews for
                        selection will be conducted soon. Please stay connected through our official
                        WhatsApp channel for updates on your interview date and venue:
                        <a href="https://whatsapp.com/channel/0029VayWRoWKgsNsomnaAp0t"
                        style="color:#0d6efd; text-decoration:underline;">
                        https://whatsapp.com/channel/0029VayWRoWKgsNsomnaAp0t
                        </a>
                    </p>

                    <p style="margin-bottom:10px;">
                        In the meantime, kindly ensure that all your documents are prepared and ready for verification.
                    </p>

                    <p style="margin-top:15px; margin-bottom:0;">Best regards,</p>
                    <p style="margin-top:0;">PITP – MUET</p>
                    </div>
');
        }
    }
}
