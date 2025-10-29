<div id="rootDiv">
    @role('admin')
        <div class="mainParent">
            <div
                class="flex gap-5  card bg-white px-6 pb-3 pt-6 rounded-t-xl align-end border-t border-r border-l border-t-gray-200">

                <div class="filter-parent w-1/3">
                    <!-- Input Field -->
                    <label
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">Center
                        Selection</label>
                    <select wire:model="study_center_filter"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Center</option>
                        @foreach (config('filters.study_centers') as $value => $label)
                            <option wire:key="{{ $value }}" value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-parent w-1/3">
                    <!-- Input Field -->
                    <label
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">Domicile
                        Selection</label>
                    <select wire:model="domicile_category_filter"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Domicile District</option>
                        @foreach (config('filters.districts') as $key => $district)
                            <option value="{{ $key }}">{{ $district }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-parent w-1/3">
                    <label
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">Gender
                        Selection</label>
                    <!-- Input Field -->
                    <select wire:model="gender_filter"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="transgender">Transgender</option>
                    </select>
                </div>
                {{-- <div class="filter-parent w-1/3">
                    <!-- Input Field -->
                    <label
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">Batch
                        Selection</label>
                    <select wire:model.live="batch_id"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Batch</option>
                        @foreach ($batches as $batch)
                            <option wire:key="{{ $batch->id }}" value="{{ $batch->id }}">{{ $batch->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-parent w-1/3">
                    <label
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">Course
                        Selection</label>
                    <!-- Input Field -->
                    <select wire:model="course_filter"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach

                    </select>
                </div> --}}

                <div class="filter-parent w-1/3">
                    <label
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">Highest.Qualification
                        Selection</label>
                    <select wire:model="highest_qualification_filter"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Highest Qualification</option>
                        @foreach (config('filters.qualifications') as $value => $label)
                            <option wire:key="{{ $value }}" value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div
                class="flex gap-5 mb-3 card bg-white px-6 pb-6 pt-3 rounded-b-xl align-end border-b border-r border-l border-b-gray-200">

                <div class="filter-parent w-1/3">
                    <label
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">Age
                        Group
                        Selection</label>
                    <select wire:model.live="age_group_filter"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Age Group</option>
                        <option value="below 18"> Below 18</option>
                        <option value="18–22">18–22</option>
                        <option value="23–26">23–26</option>
                        <option value="27-28">27-28</option>
                    </select>
                </div>
                {{-- <div class="filter-parent w-1/3">
                    <label
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 font-['Open_Sans']">Time
                        Slot
                        Selection</label>
                    <select wire:model="time_slot_filter"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Time Slot</option>
                        <option value="9 AM to 12 PM">Morning (9AM to 12PM)</option>
                        <option value="12 PM to 3 PM">Afternoon (12PM to 3PM)</option>
                        <option value="3 PM to 6 PM">Early Evening (3PM to 6PM)</option>
                        <option value="6 PM to 9 PM">Late Evening (6PM to 9PM)</option>
                        <option value="Sat & Sun (Weekend)">Weekend (Sat & Sun)</option>
                    </select>
                </div> --}}

                <div class="filter-parent w-1/3 flex items-end">
                    <button wire:click="applyFilters"
                        class="bg-blue-600 px-3 py-3 text-sm text-white rounded-xl flex items-center justify-center gap-2"
                        wire:loading.attr="disabled">

                        <!-- Spinner -->
                        <svg wire:loading wire:target="applyFilters" class="animate-spin h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <!-- Text -->
                        <span wire:loading wire:target="applyFilters">Applying...</span>
                        <span wire:loading.remove wire:target="applyFilters">Apply Filters</span>
                    </button>
                </div>

            </div>
            <div class="grid grid-cols-12 gap-4 md:gap-6 ">
                <div class="col-span-12 xl:col-span-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
                        <!-- Metric Item Start -->
                        <x-metric-card headingLabel="Registered Students" :count="$registeredtudentsCount" />
                        <!-- Metric Item End -->

                        <!-- Metric Item Start -->
                        <x-metric-card headingLabel="Enrolled Students" :count="$enrolledstudentsCount" />
                        <!-- Metric Item End -->

                        {{-- <!-- Metric Item Start -->
                        <x-metric-card headingLabel="Phases" :count="$phasesCount" />
                        <!-- Metric Item End -->

                        <!-- Metric Item Start -->
                        <x-metric-card headingLabel="Campus" :count="$campusCount" />
                        <!-- Metric Item End --> --}}


                    </div>

                </div>
                {{-- <div class="col-span-12 xl:col-span-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
                        <!-- Metric Item Start -->
                        <x-metric-card headingLabel="Teachers" :count="$teachersCount" />
                        <!-- Metric Item End -->

                        <!-- Metric Item Start -->
                        <x-metric-card headingLabel="Courses" :count="$coursesCount" />
                        <!-- Metric Item End -->

                        <!-- Metric Item Start -->
                        <x-metric-card headingLabel="Batches" :count="$batchesCount" />
                        <!-- Metric Item End -->
                    </div>

                </div> --}}
            </div>
            <div class="py-12">
                <div class="max-w-7xl flex">
                    {{-- 💡 Embed the Livewire Component here --}}
                    @livewire('enroll-student-gender-chart', key('gender-chart'))
                    @livewire('enroll-student-age-group', key('age-group'))
                </div>
            </div>
            {{-- <div class="">
                <div class="max-w-7xl flex">
                    @livewire('enroll-by-time-slot', key('time-slot'))

                </div>
            </div> --}}
            <div class="mt-3">
                <div class="max-w-7xl flex">
                    @livewire('student-education-background-chart', key('education-background'))
                    @livewire('course-wise-enrollment-chart', key('course-wise-enrollment-chart'))
                </div>
            </div>
            <div class="mt-3">

                <div class="mt-3 max-w-7xl flex">
                    @livewire('center-wise-enrollment-chart', key('center-wise-enrollment-chart'))
                    @livewire('enrollment-domicile-district-chart', key('enrollment-domicile-district-chart'))
                    {{-- @livewire('domicile-wise-enrollment-chart', key('domicile-wise-enrollment-chart')) --}}

                </div>
                <div class="mt-3 max-w-7xl flex">
                    {{-- @livewire('enroll-students-course-choice-wise-chart', key('enroll-students-course-choice-wise-chart')) --}}
                </div>
                {{-- <div class="mt-3 max-w-7xl flex">
                </div> --}}
            </div>
        </div>
    @endrole
    <script>
        // Gender Chart (Pie)
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($genderCounts->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($genderCounts->toArray())) !!},
                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                }]
            },
        });
    </script>
    @role('student')
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 p-6" x-data="{ activeTab: 'modules' }">
            <!-- Left Column -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Welcome Card -->
                <div class="bg-white rounded-xl p-6 border border-gray-300 shadow-md">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Welcome back, {{ Auth::user()->full_name }} !</h2>
                        </div>
                    </div>
                    <div class="mt-10 overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                            <thead
                                class="bg-slate-50 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Campus</th>
                                    <th class="px-6 py-4">Batch</th>
                                    <th class="px-6 py-4">Course</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach ($enrollments as $enrollment)
                                    <tr class="hover:bg-slate-50 transition">
                                        <!-- Campus -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 bg-indigo-100 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 10l9-6 9 6v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 21V9h6v12" />
                                                    </svg>
                                                </div>
                                                <span>{{ $enrollment->campus->title }}</span>
                                            </div>
                                        </td>

                                        <!-- Batch -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                                                    </svg>
                                                </div>
                                                <span>{{ $enrollment->batch->title }}</span>
                                            </div>
                                        </td>

                                        <!-- Course -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 text-yellow-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 12V4l9 5-9 5z" />
                                                    </svg>
                                                </div>
                                                <span>{{ $enrollment->course->title }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        @endrole
        @role('teacher')
            <div class="grid grid-cols-12 gap-4 md:gap-6 ">
                <div class="col-span-12 xl:col-span-6">
                    <!-- Card One -->
                    {{-- @include('partials.cards.card1') --}}
                    <!-- Card One -->

                </div>
                <div class="col-span-12 xl:col-span-6">
                    <!-- ====== Card Two Start -->
                    {{-- @include('partials.cards.card2') --}}

                    <!-- ====== Card Two End -->
                </div>
            </div>
        @endrole
    </div>
