    <div class="col-lg-12 w-100 formify-booking-column-main formify-mg-top-30">
        <form wire:submit.prevent="save" id="multiStepForm" enctype="multipart/form-data"
            class="formify-forms formify-forms__booking formify-form-shadow" action="#">
            @csrf
            <div class="formify-form__bookingv2--box">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {!! session('message') !!}

                    </div>
                @else
                    <div class="formify-form__form-box formify-form__form-box--v5">
                        <div class="list-group formify-form__nav formify-form__booking-nav" id="list-tab"
                            role="tablist">
                            <a class="list-group-item {{ $activeTab === 'step1' ? 'active' : '' }}"
                                wire:click="switchTab('step1')" data-bs-toggle="list" href="#step1" role="tab">
                                <span class="fstp-count"><span>1</span> <i class="fas fa-check"></i></span>
                                <span class="fstp-text">Personal Details</span>
                            </a>
                            <a class="list-group-item {{ $activeTab === 'step2' ? 'active' : '' }}"
                                wire:click="switchTab('step2')" data-bs-toggle="list" href="#step2" role="tab">
                                <span class="fstp-count"><span>2</span> <i class="fas fa-check"></i></span>
                                <span class="fstp-text">Course Preferences</span>
                            </a>
                            <a class="list-group-item {{ $activeTab === 'step3' ? 'active' : '' }}"
                                wire:click="switchTab('step3')" data-bs-toggle="list" href="#step3" role="tab">
                                <span class="fstp-count"><span>3</span> <i class="fas fa-check"></i></span>
                                <span class="fstp-text">Additional Information</span>
                            </a>
                        </div>

                        <div class="tab-content">
                            <!-- Step 1: Personal Information -->
                            <div class="tab-pane fade {{ $activeTab === 'step1' ? 'show active' : '' }}" id="step1">
                                <div class="formify-forms__booking-form formify-mg-top-30">
                                    <h5 class="mb-0 mt-3 pb-0 ms-2">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        If your file size is above the allowed limit (256 kb), please use the following
                                        link
                                        to compress it before submission:
                                        <a class="text-primary text-decoration-underline ms-4 mt-1" target="_blank"
                                            href="https://compress.filexl.com">Click here to compress</a>
                                    </h5>
                                    <div class="formify-forms__booking-form">
                                        <div class="formify-forms__booking-form--single">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Full Name (as per CNIC/B-Form/Marksheet) *</label>
                                                    <div class="formify-forms__input">
                                                        <input type="text" wire:model="full_name"
                                                            placeholder="Enter name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Father's Name *</label>
                                                    <div class="formify-forms__input">
                                                        <input type="text" wire:model="father_name"
                                                            placeholder="Enter Father Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="formify-mg-top-20">
                                                <label>Gender (as per CNIC) *</label>
                                                <div class="">
                                                    <select class="form-select" wire:model="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="transgender">Transgender</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <div class="formify-forms__input">
                                                        <input type="date" wire:model="date_of_birth">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="formify-forms__input">
                                                        <label>CNIC Number (without dashes) *</label>
                                                        <input type="text" wire:model="cnic_number"
                                                            oninput="validateNumber(this,13)" placeholder="Your CNIC"
                                                            id="cnic-number">
                                                        @error('cnic_number')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Email Address*</label>
                                                    <div class="formify-forms__input">
                                                        <input type="email" wire:model="email"
                                                            placeholder="Your Email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label> WhatsApp Contact Number (e.g., 03xxxxxxxxx) *</label>
                                                    <div class="formify-forms__input">
                                                        <input type="text" oninput="validateNumber(this,11)"
                                                            wire:model="contact_number" placeholder="Your Contact">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Upload Profile Picture (passport size, max file size 256 kb)
                                                        *</label>
                                                    <div class="formify-forms__input">
                                                        <input type="file" wire:model="profile_picture"
                                                            name="profile_picture" accept=".jpg,.jpeg,.png,.pdf"
                                                            data-max-size-kb="256"
                                                            style="padding-top: 13px; font-size: 12px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <h3 class="text-center bg-light p-2 mt-3">Education</h3>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label> Highest Qualification</label>
                                                    <div class="formify-forms__input">
                                                        <select class="form-select"
                                                            wire:model.live="highest_qualification">
                                                            <option selected>Select Qualification</option>
                                                            <option value="matric">Matric</option>
                                                            <option value="intermediate">Intermediate</option>
                                                            <option value="graduate">Graduate</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="formify-mg-top-20">
                                                <label>Name of Last Attended Institution? *</label>
                                                <div class="form-grouping form-group__flex">
                                                    <input type="text" wire:model="most_recent_institution"
                                                        placeholder="Most recent institution name">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Upload Latest Marksheet/Certificate (Max 256 KB)</label>
                                                    <div class="formify-forms__input">
                                                        <input type="file" wire:model="intermediate_marksheet"
                                                            name="intermediate_marksheet" data-max-size-kb="256"
                                                            accept=".jpg,.jpeg,.png,.pdf"
                                                            style="padding-top: 13px; font-size: 12px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" formify-mg-top-20">
                                                <label>Domicile District *</label>
                                                <div class="form-grouping">
                                                    <select wire:model="domicile_district" class="form-select"
                                                        required="required">
                                                        <option>Select District</option>
                                                        @foreach ($districts as $key => $label)
                                                            <option value="{{ $key }}">{{ $label }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="form-grouping">
                                                        <label>Domicile Category</label>
                                                        <select wire:model="domicile_category" class="form-select"
                                                            required="required">
                                                            <option selected>Select category</option>
                                                            <option value="urban">Urban</option>
                                                            <option value="rural">Rural</option>

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Upload Your Domicile or Form C (maximum file size is 256kb)
                                                        *</label>
                                                    <div class="formify-forms__input">
                                                        <input type="file" wire:model="domicile_form_c"
                                                            name="domicile_form_c" accept=".jpg,.jpeg,.png,.pdf"
                                                            data-max-size-kb="256"
                                                            style="padding-top: 13px; font-size: 12px;">
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-group formify-mg-top-20">
                                                <div class="formify-forms__button formify-forms__button-between">
                                                    <button class="formify-btn next-step"
                                                        wire:click="switchTab('step2')">
                                                        Next
                                                        <svg width="16" height="14" viewBox="0 0 16 14"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M1.125 7H14.875M14.875 7L9.25 1.375M14.875 7L9.25 12.625"
                                                                stroke="white" stroke-width="1.4"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- course preferences --}}
                            <div class="tab-pane fade {{ $activeTab === 'step2' ? 'show active' : '' }}"
                                id="step2">


                                <div class="formify-mg-top-20">
                                    <label>Preferred Center for Study? *</label>
                                    <div class="form-grouping form-group__flex">
                                        <select class="form-select" wire:model="preferred_study_center">
                                            <option value="">Select Center</option>
                                            @foreach (config('filters.study_centers') as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="formify-mg-top-20">
                                    <label>Preferred Time Slot *</label>
                                    <div class="form-grouping form-group__flex">
                                        <select class="form-select" wire:model="preferred_time_slot">
                                            <option value="">Select Time Slot</option>
                                            <option value="9 AM to 12 PM">9 AM - 12 PM (Morning)</option>
                                            <option value="12 PM to 3 PM">12 PM - 3 PM (Afternoon)</option>
                                            <option value="3 PM to 6 PM">3 PM - 6 PM (Evening)</option>
                                            <option value="6 PM to 9 PM">6 PM - 9 PM (Evening)</option>
                                            <option value="Sat & Sun (Weekend)">Sat & Sun (Weekend)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="formify-forms__booking-form--single formify-mg-top-20">
                                            <label>1st Choice *</label>
                                            <div class="form-grouping">
                                                {{-- enable course-choice it will reset course everytime tab changes --}}
                                                <select name="course_choice_1" wire:model.change="course_choice_1"
                                                    wire:key="choice1-{{ md5(json_encode($this->courseList)) }}"
                                                    class="form-control">
                                                    <option value="">Select Course</option>
                                                    @foreach ($this->availableCoursesForChoice1 as $course)
                                                        <option value="{{ $course }}">
                                                            {{ $course }}</option>
                                                    @endforeach
                                                </select>
                                                @error('course_choice_1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="formify-forms__booking-form--single formify-mg-top-20">
                                            <label>2nd Choice *</label>

                                            <div class="form-grouping form-group__flex">
                                                <select class="form-control" name="course_choice_2"
                                                    wire:key="choice2-{{ md5($this->course_choice_1) }}"
                                                    wire:model.change="course_choice_2">
                                                    <option value="">Select Course</option>
                                                    @foreach ($this->availableCoursesForChoice2 as $course)
                                                        <option value="{{ $course }}">
                                                            {{ $course }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="formify-forms__booking-form--single formify-mg-top-20">
                                            <label>3rd Choice *</label>

                                            <div class="form-grouping form-group__flex">
                                                <select class="form-control" name="course_choice_3"
                                                    wire:key="choice3-{{ md5($this->course_choice_1 . '|' . $this->course_choice_2) }}"
                                                    wire:model.change="course_choice_3">
                                                    <option value="">Select Course</option>
                                                    @foreach ($this->availableCoursesForChoice3 as $course)
                                                        <option value="{{ $course }}">
                                                            {{ $course }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="formify-forms__booking-form--single formify-mg-top-20">
                                            <label>4th Choice *</label>

                                            <div class="form-grouping form-group__flex">
                                                <select class="form-control" name="course_choice_4"
                                                    wire:key="choice4-{{ md5($this->course_choice_1 . '|' . $this->course_choice_2 . '|' . $this->course_choice_3) }}""
                                                    wire:model.change="course_choice_4">
                                                    <option value="">Select Course</option>
                                                    @foreach ($this->availableCoursesForChoice4 as $course)
                                                        <option value="{{ $course }}">
                                                            {{ $course }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mb-0 mt-3 pb-0 ms-2"><i class="fa-solid fa-triangle-exclamation"></i>
                                        The
                                        availability of course, center, and time slot depends on seat capacity and total
                                        registrations.</h5>

                                </div>


                                <div class="form-group formify-mg-top-20">
                                    <div class="formify-forms__button gap15">
                                        <button class="formify-btn prev-step" wire:click="switchTab('step1')">
                                            <svg width="16" height="11" viewBox="0 0 16 11" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0.21792 4.977L4.97925 0.242992C5.26975 -0.0458411 5.74088 -0.0458411 6.03138 0.242992C6.32194 0.531885 6.32194 1.0002 6.03138 1.28909L2.54008 4.76036H15.256C15.6669 4.76036 16 5.09156 16 5.50004C16 5.90847 15.6669 6.23973 15.256 6.23973H2.54008L6.03127 9.711C6.32183 9.99989 6.32183 10.4682 6.03127 10.7571C5.88604 10.9014 5.69559 10.9737 5.5052 10.9737C5.3148 10.9737 5.12441 10.9014 4.97913 10.7571L0.21792 6.02309C-0.0726395 5.7342 -0.0726395 5.26589 0.21792 4.977Z">
                                                </path>
                                            </svg>
                                            Back
                                        </button>
                                        <button class="formify-btn next-step" wire:click="switchTab('step3')">
                                            Next
                                            <svg width="20" height="15" viewBox="0 0 20 15" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19.7276 6.84612L13.7759 0.928618C13.4128 0.567576 12.8239 0.567576 12.4608 0.928618C12.0976 1.28973 12.0976 1.87512 12.4608 2.23624L16.8249 6.57532H0.929947C0.416393 6.57532 0 6.98933 0 7.49993C0 8.01047 0.416393 8.42454 0.929947 8.42454H16.8249L12.4609 12.7636C12.0977 13.1247 12.0977 13.7101 12.4609 14.0712C12.6424 14.2517 12.8805 14.342 13.1185 14.342C13.3565 14.342 13.5945 14.2517 13.7761 14.0712L19.7276 8.15374C20.0908 7.79263 20.0908 7.20724 19.7276 6.84612Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Select Courses -->
                            <div class="tab-pane fade {{ $activeTab === 'step3' ? 'show active' : '' }}"
                                id="step3">
                                <div class="formify-forms__booking-form formify-mg-top-30">
                                    <div class="formify-forms__booking-form">
                                        <div class="formify-forms__booking-form--single">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="formify-forms__booking-form--single formify-mg-top-20">
                                                        <label>Do you have a disability?</label>
                                                        <div class="form-grouping d-flex gap-2 form-group__flex">
                                                            <div class="form-check d-flex align-items-center gap-2 ">
                                                                <input class="" style="height:16px;width:16px;"
                                                                    type="radio" name="participated_yes"
                                                                    id="participated_yes" value="yes"
                                                                    wire:model="have_disability" required="">
                                                                <label class="form-check-label m-0"
                                                                    for="participated_yes">Yes</label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center gap-2 ">
                                                                <input class="" style="height:16px;width:16px;"
                                                                    type="radio" name="participated_yes"
                                                                    id="participated_yes" value="yes"
                                                                    wire:model="have_disability" required="">
                                                                <label class="form-check-label m-0"
                                                                    for="participated_yes">No</label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="formify-forms__booking-form--single formify-mg-top-20">
                                                        <label>Monthly Household Income*</label>

                                                        <div class="form-grouping d-flex form-group__flex">
                                                            <select class="form-control "
                                                                wire:model="monthly_household_income">
                                                                <option value="">Select Household Income</option>
                                                                <option value="Below PKR 25,000">Below PKR 25,000
                                                                </option>
                                                                <option value="25,001 – 50,000">25,001 – 50,000
                                                                </option>
                                                                <option value="50,001 – 75,000">50,001 – 75,000
                                                                </option>
                                                                <option value="75,001 – 100,000">75,001 – 100,000
                                                                </option>
                                                                <option value="Above PKR 100,000">Above PKR 100,000
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="formify-forms__booking-form--single formify-mg-top-20">
                                                        <label>Have you participated in
                                                            PITP previously?</label>

                                                        <div class="form-grouping d-flex gap-2 form-group__flex">
                                                            <div class="form-check d-flex align-items-center gap-2 ">
                                                                <input class="" style="height:16px;width:16px;"
                                                                    type="radio" id="participated_yes"
                                                                    wire:model.change="participated_previously"
                                                                    name="participated_previously" value="yes"
                                                                    required="">
                                                                <label class="form-check-label m-0"
                                                                    for="participated_yes">Yes</label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center gap-2 ">
                                                                <input class="" style="height:16px;width:16px;"
                                                                    type="radio" id="participated_yes"
                                                                    name="participated_previously" value="no"
                                                                    wire:model.change="participated_previously"
                                                                    required="">
                                                                <label class="form-check-label m-0"
                                                                    for="participated_yes">No</label>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                                @if ($participated_previously === 'yes')
                                                    <div id="additionalFields" class="col-12">
                                                        <div class="form-group">
                                                            <label for="phase">Phase</label>
                                                            <input wire:model="phase_if_participated" type="text"
                                                                id="phase" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="course_name">Course Name</label>
                                                            <input wire:model="course_if_participated" type="text"
                                                                id="course_name" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="center">Center</label>
                                                            <input wire:model="center_if_participated" type="text"
                                                                id="center" name="center" class="form-control">
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-12">
                                                    <div class="formify-forms__booking-form--single formify-mg-top-20">
                                                        <label>How did you hear about
                                                            PITP?</label>

                                                        <div class="form-grouping form-group__flex">
                                                            <select class="form-control " wire:model="from_source"
                                                                required="required">
                                                                <option value="">Select option</option>
                                                                <option value="socail media">Social Media</option>
                                                                <option value="friend/family">Friend/Family</option>
                                                                <option value="university">University </option>
                                                                <option value="post/banner">Poster/Banner </option>
                                                                <option value="whatsapp group">WhatsApp Group</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group form-group__flex">
                                                        <div class=" d-flex align-items-start gap-2">
                                                            <input class=""
                                                                style="height:26px !important;width:45px !important; margin-top:3px;"
                                                                type="checkbox" id="info_confirm"
                                                                wire:model.change="info_confirm" required>
                                                            <label class="form-check-label" for="info_confirm"
                                                                style="line-height:1.4;">
                                                                I confirm that all the information provided above is
                                                                accurate and complete to the best of my knowledge.
                                                                I understand that any false or misleading information
                                                                may
                                                                result in disqualification from the program.
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group formify-mg-top-20">
                                            <div class="formify-forms__button gap15">
                                                <button class="formify-btn prev-step" wire:click="switchTab('step2')">
                                                    <svg width="16" height="11" viewBox="0 0 16 11"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.21792 4.977L4.97925 0.242992C5.26975 -0.0458411 5.74088 -0.0458411 6.03138 0.242992C6.32194 0.531885 6.32194 1.0002 6.03138 1.28909L2.54008 4.76036H15.256C15.6669 4.76036 16 5.09156 16 5.50004C16 5.90847 15.6669 6.23973 15.256 6.23973H2.54008L6.03127 9.711C6.32183 9.99989 6.32183 10.4682 6.03127 10.7571C5.88604 10.9014 5.69559 10.9737 5.5052 10.9737C5.3148 10.9737 5.12441 10.9014 4.97913 10.7571L0.21792 6.02309C-0.0726395 5.7342 -0.0726395 5.26589 0.21792 4.977Z">
                                                        </path>
                                                    </svg>
                                                    Back
                                                </button>
                                                <button @disabled(!$info_confirm) id="submit_button" type="submit"
                                                    class="formify-btn">
                                                    Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Welcome Banner -->

            </div>
        </form>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function validateNumber(el, limit) {
                el.value = el.value.replace(/\D/g, '');
                // Trim to limit
                if (el.value.length > limit) {
                    el.value = el.value.slice(0, limit);
                }
            }


            function validateFileSize(inputElement) {
                const maxSizeInKB = $(inputElement).data('max-size-kb'); // Get the max size from the data attribute
                const maxSizeInBytes = maxSizeInKB * 1024; // Convert KB to bytes
                const file = inputElement.files[0];

                if (file && file.size > maxSizeInBytes) {
                    alert(`File size exceeds ${maxSizeInKB}KB. Please upload a smaller file.`);
                    $(inputElement).val(''); // Clear the input
                }
            }


            $(document).on('change', 'input[type="file"]', function() {
                validateFileSize(this);
            });

            document.addEventListener("livewire:load", function() {
                rebuildDropdowns();
                Livewire.hook('message.processed', () => {
                    rebuildDropdowns();
                });
            });
        </script>
    </div>
