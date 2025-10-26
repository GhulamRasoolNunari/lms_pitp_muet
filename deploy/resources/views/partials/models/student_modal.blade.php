<div x-data="{ showStudentViewModal: false }" x-on:open-task-view-modal.window="showStudentViewModal = true" style="z-index: 99999">

    <!-- Enhanced Modal -->
    <div x-show="showStudentViewModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 flex items-center justify-center p-4 overflow-y-auto z-50" style="display: none;">

        <!-- Enhanced Background Overlay -->
        <div @click="showStudentViewModal = false"
            class="fixed inset-0 bg-gradient-to-br from-slate-900/80 via-slate-800/60 to-slate-900/80 backdrop-blur-md">
        </div>

        <!-- Enhanced Modal Content -->
        <div @click.outside="showStudentViewModal = false"
            class="relative z-10 w-full max-w-5xl bg-white dark:bg-slate-900 rounded-3xl shadow-2xl overflow-hidden max-h-[95vh] border border-slate-200 dark:border-slate-700">

            <!-- Gradient Header -->
            <div
                class="bg-gradient-to-br from-slate-800 via-slate-900 to-black dark:from-slate-900 dark:via-black dark:to-slate-950 p-6 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-1 font-['Open_Sans']">Student Profile</h2>
                        <p class="text-white/80 text-sm font-['Open_Sans']">Complete student information</p>
                    </div>
                    <button @click="showStudentViewModal = false"
                        class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all duration-200 hover:scale-110 border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-8 overflow-y-auto max-h-[calc(95vh-120px)] bg-slate-50 dark:bg-slate-900">
                <!-- Enhanced Profile Picture Section -->
                <div class="flex justify-center mb-8 relative">
                    <div class="relative group">
                        @if ($profile_picture)
                            <img src="{{ asset('attachments/profile_pictures/' . $profile_picture) }}"
                                class="w-36 h-36 rounded-full object-cover border-4 border-white shadow-2xl dark:border-slate-700 group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div
                                class="w-36 h-36 flex items-center justify-center rounded-full bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-800 text-slate-500 shadow-2xl group-hover:scale-105 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-slate-400"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 14.25A4.25 4.25 0 0 1 22.25 18.5v1.25a.75.75 0 0 1-.75.75H2.5a.75.75 0 0 1-.75-.75V18.5a4.25 4.25 0 0 1 4.25-4.25h12zm-6-9a3.75 3.75 0 1 0 0 7.5A3.75 3.75 0 0 0 12 5.25z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Enhanced Info Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm mb-8">
                    @php
                        // Normalize a truthy "yes"
                        $didParticipate = in_array(
                            strtolower((string) ($participated_previously ?? '')),
                            ['yes', 'y', '1', 'true'],
                            true,
                        );

                        $fields = [
                            'Full Name' => ['value' => $full_name, 'icon' => '👤'],
                            'Father Name' => ['value' => $father_name, 'icon' => '👨‍👦'],
                            'Gender' => ['value' => $gender, 'icon' => '⚧'],
                            'CNIC Number' => ['value' => $cnic_number, 'icon' => '🪪'],
                            'Contact Number' => ['value' => $contact_number, 'icon' => '📞'],
                            'Date of Birth' => ['value' => $date_of_birth, 'icon' => '🎂'],
                            'Domicile Category' => ['value' => $domicile_category, 'icon' => '🏷️'],
                            'Domicile District' => ['value' => $domicile_district, 'icon' => '🗺️'],
                            'Highest Qualification' => ['value' => $highest_qualification, 'icon' => '🎓'],
                            'Most Recent Institution' => ['value' => $most_recent_institution, 'icon' => '🏫'],
                            'University Name' => ['value' => $university_name, 'icon' => '🏛️'],
                            'Preferred Study Center' => ['value' => $preferred_study_center, 'icon' => '📍'],
                            'Preferred Time Slot' => ['value' => $preferred_time_slot, 'icon' => '🕒'],
                            'Course Choice 1' => ['value' => $course_choice_1, 'icon' => '📚'],
                            'Course Choice 2' => ['value' => $course_choice_2, 'icon' => '📚'],
                            'Course Choice 3' => ['value' => $course_choice_3, 'icon' => '📚'],
                            'Course Choice 4' => ['value' => $course_choice_4, 'icon' => '📚'],
                            'Have Disability' => ['value' => $have_disability, 'icon' => '♿'],
                            'Monthly Household Income' => ['value' => $monthly_household_income, 'icon' => '💵'],
                            'Participated Previously' => ['value' => $didParticipate ? 'Yes' : 'No', 'icon' => '🔁'],
                        ];

                        if ($didParticipate) {
                            $fields = array_merge($fields, [
                                'Course (if participated)' => [
                                    'value' => $course_if_participated ?? null,
                                    'icon' => '📚',
                                ],
                                'Phase (if participated)' => [
                                    'value' => $phase_if_participated ?? null,
                                    'icon' => '📅',
                                ],
                                'Center (if participated)' => [
                                    'value' => $center_if_participated ?? null,
                                    'icon' => '📍',
                                ],
                            ]);
                        }
                    @endphp

                    @foreach ($fields as $label => $data)
                        <div class="group hover:scale-105 transition-all duration-300">
                            <div
                                class="bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-700 p-5 rounded-2xl border border-slate-200 dark:border-slate-600 hover:shadow-lg hover:border-slate-400 dark:hover:border-slate-500 transition-all duration-300">
                                <div class="flex items-start gap-3">
                                    <div class="text-2xl bg-slate-100 dark:bg-slate-700 p-2 rounded-xl">
                                        {{ $data['icon'] }}
                                    </div>
                                    <div class="flex-1">
                                        <div
                                            class="font-semibold text-slate-600 dark:text-slate-400 text-xs uppercase tracking-wide mb-1 font-['Open_Sans']">
                                            {{ $label }}
                                        </div>
                                        <div class="text-slate-800 dark:text-slate-200 font-medium font-['Open_Sans']">
                                            {{ filled($data['value']) ? $data['value'] : 'Not specified' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Enhanced Documents Section -->
                <div class="mb-8">
                    <h3
                        class="text-xl font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2 font-['Open_Sans']">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Documents
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Intermediate Marksheet -->
                        <div class="group hover:scale-105 transition-all duration-300">
                            <div
                                class="flex items-center gap-4 p-6 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800/50 dark:to-slate-700/50 border border-slate-300 dark:border-slate-600 hover:shadow-lg transition-all duration-300">
                                <div
                                    class="w-14 h-14 bg-slate-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                    📄
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-slate-800 dark:text-slate-200 mb-1 font-['Open_Sans']">
                                        Latest Marksheet</div>
                                    @if ($intermediate_marksheet)
                                        <a href="{{ asset('attachments/marksheets/' . $intermediate_marksheet) }}"
                                            target="_blank" download
                                            class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 font-medium text-sm transition-colors duration-200 font-['Open_Sans']">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>

                                            Click to download
                                        </a>
                                    @else
                                        <span class="text-slate-500 text-sm flex items-center gap-2 font-['Open_Sans']">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            No file uploaded
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Domicile Form C -->
                        <div class="group hover:scale-105 transition-all duration-300">
                            <div
                                class="flex items-center gap-4 p-6 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800/50 dark:to-slate-700/50 border border-slate-300 dark:border-slate-600 hover:shadow-lg transition-all duration-300">
                                <div
                                    class="w-14 h-14 bg-slate-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                    📋
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-slate-800 dark:text-slate-200 mb-1 font-['Open_Sans']">
                                        Domicile Form C</div>
                                    @if ($domicile_form_c)
                                        <a href="{{ asset('attachments/domicile_form_c/' . $domicile_form_c) }}"
                                            target="_blank" download
                                            class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 font-medium text-sm transition-colors duration-200 font-['Open_Sans']">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                            Click to download
                                        </a>
                                    @else
                                        <span
                                            class="text-slate-500 text-sm flex items-center gap-2 font-['Open_Sans']">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            No file uploaded
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Enrollment Details Table (Without Index) -->


                <!-- Enhanced Footer -->
                <div class="flex justify-end gap-4">
                    <button @click="showStudentViewModal = false"
                        class="px-8 py-3 rounded-2xl bg-gradient-to-r from-slate-200 to-slate-300 text-slate-700 hover:from-slate-300 hover:to-slate-400 dark:from-slate-700 dark:to-slate-800 dark:text-white dark:hover:from-slate-600 dark:hover:to-slate-700 font-medium transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-['Open_Sans']">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Enrol Student Modal --}}
<div x-data="{ showEnrollViewModal: false }" x-on:open-enrol-view-modal.window="showEnrollViewModal = true"
    x-on:close-enrol-view-modal.window="showEnrollViewModal = false" style="z-index: 99999">

    <!-- Enhanced Modal -->
    <div x-show="showEnrollViewModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 flex items-center justify-center p-4 z-50"
        style="display: none;">

        <!-- Enhanced Background Overlay -->
        <div @click="showEnrollViewModal = false" class="fixed inset-0 backdrop-blur-lg bg-slate-900/80">
        </div>

        <!-- Enhanced Modal Content with 80% height -->
        <div @click.outside="showEnrollViewModal = false"
            class="relative z-10 w-full max-w-4xl h-[80vh] bg-white dark:bg-slate-900 rounded-3xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700 flex flex-col">

            <!-- Fixed Header with Dark Blue Theme -->
            <div
                class="bg-gradient-to-br from-slate-800 via-slate-900 to-black dark:from-slate-900 dark:via-black dark:to-slate-950 p-6 text-white relative overflow-hidden flex-shrink-0">
                <div class="absolute inset-0 bg-black/10"></div>
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16">
                </div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12">
                </div>

                <div class="relative flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-1 font-['Open_Sans']">Enroll Student</h2>
                            <p class="text-white/80 text-sm font-['Open_Sans']">Student enrollment process</p>
                        </div>
                    </div>
                    <button @click="showEnrollViewModal = false"
                        class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all duration-200 hover:scale-110 border border-white/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto p-8 bg-slate-50 dark:bg-slate-900">
                <div class="space-y-8">

                    <!-- Student Information Display Block -->
                    <div
                        class="bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800/50 dark:to-slate-700/50 p-6 rounded-3xl border-2 border-slate-300 dark:border-slate-600 shadow-lg backdrop-blur-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-slate-600 to-slate-700 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200 font-['Open_Sans']">Student
                                Information</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Student Name Display -->
                            <div
                                class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-300 dark:border-slate-600 hover:shadow-md transition-all duration-300 hover:border-slate-400 dark:hover:border-slate-500">
                                <div
                                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2 font-['Open_Sans']">
                                    Student Name</div>
                                <div class="text-lg font-bold text-slate-800 dark:text-white font-['Open_Sans']">
                                    {{ $this->full_name ?: 'Not Available' }}
                                </div>
                            </div>

                            <!-- Father Name Display -->
                            <div
                                class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-300 dark:border-slate-600 hover:shadow-md transition-all duration-300 hover:border-slate-400 dark:hover:border-slate-500">
                                <div
                                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2 font-['Open_Sans']">
                                    Father Name</div>
                                <div class="text-lg font-bold text-slate-800 dark:text-white font-['Open_Sans']">
                                    {{ $this->father_name ?: 'Not Available' }}
                                </div>
                            </div>

                            <!-- CNIC Number Display -->
                            <div
                                class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-300 dark:border-slate-600 hover:shadow-md transition-all duration-300 hover:border-slate-400 dark:hover:border-slate-500">
                                <div
                                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2 font-['Open_Sans']">
                                    CNIC Number</div>
                                <div class="text-lg font-bold text-slate-800 dark:text-white font-mono">
                                    {{ $this->cnic_number ?: 'Not Available' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enrollment Details Block -->
                    <div
                        class="bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800/50 dark:to-slate-700/50 p-6 rounded-3xl border-2 border-slate-300 dark:border-slate-600 shadow-lg backdrop-blur-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-slate-600 to-slate-700 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200 font-['Open_Sans']">Enroll
                                in Course</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- Campus Selection -->
                            <div class="group">
                                <label
                                    class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">
                                    Phase Selection
                                </label>
                                <div class="relative">
                                    <select wire:model.live="phase_id"
                                        class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 dark:text-white focus:border-slate-500 focus:ring-4 focus:ring-slate-500/20 transition-all duration-300 hover:shadow-md appearance-none cursor-pointer font-['Open_Sans']">
                                        <option value="">Select Phase</option>
                                        @foreach ($phases as $phase)
                                            <option value="{{ $phase->id }}">{{ $phase->title }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('phase_id')
                                    <div class="mt-1 text-red-500 text-sm font-['Open_Sans']">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Campus Selection -->
                            <div class="group">
                                <label
                                    class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">
                                    Batch Selection
                                </label>
                                <div class="relative">
                                    <select wire:model.live="campus_id"
                                        class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 dark:text-white focus:border-slate-500 focus:ring-4 focus:ring-slate-500/20 transition-all duration-300 hover:shadow-md appearance-none cursor-pointer font-['Open_Sans']">
                                        <option value="">Select Batch</option>
                                        @foreach ($campuses as $campus)
                                            <option value="{{ $campus->id }}">{{ $campus->title }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('campus_id')
                                    <div class="mt-1 text-red-500 text-sm font-['Open_Sans']">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Batch Selection -->
                            <div class="group">
                                <label
                                    class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">
                                    Campus Selection
                                </label>
                                <div class="relative">
                                    <select wire:model.live="batch_id"
                                        class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 dark:text-white focus:border-slate-500 focus:ring-4 focus:ring-slate-500/20 transition-all duration-300 hover:shadow-md appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed font-['Open_Sans']"
                                        @if (empty($batches)) disabled @endif>
                                        <option value="">Select Campus</option>
                                        @foreach ($batches as $batch)
                                            <option value="{{ $batch->id }}">{{ $batch->title }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('batch_id')
                                    <div class="mt-1 text-red-500 text-sm font-['Open_Sans']">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Course Selection -->
                            <div class="group">
                                <label
                                    class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">
                                    Course ID Selection
                                </label>
                                <div class="relative">
                                    <select wire:model.live="course_id"
                                        class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 dark:text-white focus:border-slate-500 focus:ring-4 focus:ring-slate-500/20 transition-all duration-300 hover:shadow-md appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed font-['Open_Sans']"
                                        @if (empty($courses)) disabled @endif>
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course_detail)
                                            <option value="{{ $course_detail->id }}">{{ $course_detail->title }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('course_id')
                                    <div class="mt-1 text-red-500 text-sm font-['Open_Sans']">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <!-- Course Selection -->
                            <div class="group">
                                <label
                                    class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">
                                    Time Slot Selection
                                </label>
                                <div class="relative">
                                    <select wire:model="time_slot_id"
                                        class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 dark:text-white focus:border-slate-500 focus:ring-4 focus:ring-slate-500/20 transition-all duration-300 hover:shadow-md appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed font-['Open_Sans']"
                                        @if (empty($timeSlots)) disabled @endif>
                                        <option value="">Select timeSlots</option>
                                        @foreach ($timeSlots as $timeSlot)
                                            <option value="{{ $timeSlot->id }}">{{ $timeSlot->title }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('time_slot_id')
                                    <div class="mt-1 text-red-500 text-sm font-['Open_Sans']">{{ $message }}</div>
                                @enderror
                            </div> --}}
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div
                        class="bg-gradient-to-r from-slate-100 to-slate-200 dark:from-slate-800/30 dark:to-slate-700/30 p-4 rounded-2xl border border-slate-300 dark:border-slate-600 backdrop-blur-sm">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 bg-slate-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-800 dark:text-slate-200 mb-1 font-['Open_Sans']">
                                    Enrollment Process</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-300 font-['Open_Sans']">
                                    Student information is displayed above. Select campus, batch and course for
                                    enrollment.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fixed Footer -->
            <div class="flex-shrink-0 border-t border-slate-200 dark:border-slate-700 p-6 bg-white dark:bg-slate-900">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-slate-500 dark:text-slate-400 font-['Open_Sans']">
                        Complete enrollment details to proceed
                    </div>
                    <div class="flex gap-4">
                        <button @click="showEnrollViewModal = false"
                            class="px-6 py-3 rounded-2xl bg-gradient-to-r from-slate-200 to-slate-300 text-slate-700 hover:from-slate-300 hover:to-slate-400 dark:from-slate-700 dark:to-slate-800 dark:text-white dark:hover:from-slate-600 dark:hover:to-slate-700 font-medium transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-['Open_Sans']">
                            Cancel
                        </button>
                        <button wire:click="enrollStudent({{ $this->student_id }})"
                            class="px-6 py-3 rounded-2xl bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white font-medium transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none font-['Open_Sans']"
                            wire:loading.attr="disabled" wire:target="enrollStudent">

                            <!-- Loading State -->
                            <div wire:loading wire:target="enrollStudent" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span>Enrolling...</span>
                            </div>

                            <!-- Default State -->
                            <div wire:loading.remove wire:target="enrollStudent" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9a3 3 0 11-6 0 3 3 0 016 0zM13.5 20.25h6M16.5 17.25v6M4.5 20.25v-1.5A4.5 4.5 0 019 14.25h3" />
                                </svg>
                                <span>Enroll Student</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
