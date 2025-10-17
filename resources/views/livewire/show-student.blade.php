<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 space-y-6 xl:col-span-12">
        <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">

            <!-- Header Section -->
            <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white/90 font-['Open_Sans']">
                        Registered Students
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Manage student enrollment and view details
                    </p>
                </div>

                <!-- Total Count -->
                <div class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-lg self-start sm:self-center">
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                        {{ $students->total() }} Students
                    </span>
                </div>
            </div>
            <div class="input-parent mb-6">
                <input type="text" wire:model.live="search"
                    placeholder="Search by name, email, CNIC or contact number..."
                    class="w-full sm:w-1/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                  focus:ring focus:ring-blue-200 focus:outline-none text-sm">
            </div>
            <div class="flex gap-4 mb-6 justify-center">
                <div class="input-parent">
                    <select wire:model.live="filter_course"
                        class="w-full sm:w-1/1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                  focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                        <option value="">Select Course</option>
                        @foreach (config('filters.courses') as $course)
                            <option value="{{ $course }}">{{ $course }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-parent">
                    <select wire:model.live="filter_timeslot"
                        class="w-full sm:w-1/1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                  focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                        <option value="">Select Time slot</option>
                        @foreach (config('filters.timeSlots') as $key => $timeSlot)
                            <option value="{{ $key }}">{{ $timeSlot }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-parent">
                    <select wire:model.live="filter_qualification"
                        class="w-full sm:w-1/1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                  focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                        <option value="">Select Highest Qualification</option>
                        @foreach (config('filters.qualifications') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-parent">
                    <select wire:model.live="filter_gender"
                        class="w-full sm:w-1/1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                  focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                        <option value="">Select Gender</option>
                        @foreach (config('filters.genders') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-parent">
                    <select wire:model.live="filter_d_category"
                        class="w-full sm:w-1/1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                  focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                        <option value="">Select D.Category</option>
                        @foreach (config('filters.d_categories') as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-parent">
                    <select wire:model.live="filter_district"
                        class="w-full sm:w-1/1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                  focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                        <option>Select District</option>
                        @foreach (config('filters.districts') as $key => $label)
                            <option value="{{ $key }}">{{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-parent">
                    <select wire:model.live="filter_study_center"
                        class="w-full sm:w-1/1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                  focus:ring focus:ring-blue-200 focus:outline-none text-sm">
                        <option>Select Centers</option>
                        @foreach (config('filters.study_centers') as $key => $label)
                            <option value="{{ $key }}">{{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <!-- Divider Line -->
            <hr class="mb-4 border-slate-200 dark:border-slate-700">

            <!-- Action Section (Export & Import) -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <div>
                    <a href="{{ route('students.export') }}"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4v16h16V4H4zm4 8l4 4 4-4m-4-4v8" />
                        </svg>
                        Export Students
                    </a>
                    <a href="{{ asset('file/demo.xlsx') }}"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4v16h16V4H4zm4 8l4 4 4-4m-4-4v8" />
                        </svg>
                        Demo
                    </a>
                </div>

                <!-- Import Form -->
                <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data"
                    class="flex items-center gap-3">
                    @csrf
                    <label
                        class="inline-flex items-center gap-2 cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
                        <!-- Upload Icon -->
                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V4m0 0L8 8m4-4l4 4" />
                        </svg>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" class="hidden" required>
                    </label>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold
           text-white bg-green-600 hover:bg-green-700
           dark:bg-green-600 dark:hover:bg-green-700 rounded-xl shadow transition">

                        <!-- Icon -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4v12m0 0l-4-4m4 4l4-4M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1" />
                        </svg>

                        Import Students
                    </button>


                </form>
            </div>


            @if (session('success'))
                <div class="p-3 mt-4 text-sm text-green-700 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif


            <!-- Table Container -->
            <div class="w-full overflow-x-auto">
                <table class="min-w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="border-gray-100 border-y dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                            <th class="py-4 px-3 text-left">
                                <p class="font-semibold text-gray-600 text-sm dark:text-gray-300 font-['Open_Sans']">
                                    #
                                </p>
                            </th>
                            <th class="py-4 px-3 text-left">
                                <p class="font-semibold text-gray-600 text-sm dark:text-gray-300 font-['Open_Sans']">
                                    Student Details
                                </p>
                            </th>
                            <th class="py-4 px-3 text-left">
                                <p class="font-semibold text-gray-600 text-sm dark:text-gray-300 font-['Open_Sans']">
                                    Contact Info
                                </p>
                            </th>
                            <th class="py-4 px-3 text-center">
                                <p class="font-semibold text-gray-600 text-sm dark:text-gray-300 font-['Open_Sans']">
                                    Status
                                </p>
                            </th>
                            <th class="py-4 px-3 text-center">
                                <p class="font-semibold text-gray-600 text-sm dark:text-gray-300 font-['Open_Sans']">
                                    Actions
                                </p>
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($students as $student)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors duration-200">

                                <!-- ID Column -->
                                <td class="py-4 px-3">
                                    <div class="flex items-center">
                                        <span
                                            class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-sm font-semibold text-blue-600 dark:text-blue-400">
                                            {{ $loop->iteration }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Student Details Column -->
                                <td class="py-4 px-3">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-gray-800 dark:text-white font-['Open_Sans']">
                                            {{ $student->full_name }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Father: {{ $student->father_name }}
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">
                                            Email: {{ $student->email }}
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">
                                            CNIC: {{ $student->cnic_number }}
                                        </p>
                                    </div>
                                </td>

                                <!-- Contact Info Column -->
                                <td class="py-4 px-3">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="text-sm text-gray-600 dark:text-gray-300 font-medium">
                                            {{ $student->contact_number }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status Column -->
                                <td class="py-4 px-3">
                                    <div class="flex justify-center">
                                        @if ($student->enrolled_status == 0)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-semibold rounded-full">
                                                <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                                                Pending
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Enrolled
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Actions Column -->
                                <td class="py-4 px-3">
                                    <div class="flex items-center justify-center gap-2">

                                        <!-- View Button -->
                                        <!-- View Button - Enhanced Design -->
                                        <button wire:click="view_student({{ $student->id }})"
                                            class="group relative inline-flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transform hover:scale-105 transition-all duration-200"
                                            title="View Student Details">

                                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>

                                            <span class="hidden sm:inline">View</span>


                                        </button>

                                        <!-- Enrollment Button/Status -->
                                        @if ($student->enrolled_status == 0)
                                            <button wire:click="enroll_student({{ $student->id }})"
                                                class="group relative inline-flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transform hover:scale-105 transition-all duration-200"
                                                title="Enroll Student">

                                                <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-200"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M18 9a3 3 0 11-6 0 3 3 0 016 0zM13.5 20.25h6M16.5 17.25v6M4.5 20.25v-1.5A4.5 4.5 0 019 14.25h3" />
                                                </svg>

                                                <span class="hidden sm:inline">Enroll</span>

                                                <!-- Loading Spinner -->
                                                <div wire:loading wire:target="enroll_student({{ $student->id }})"
                                                    class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin">
                                                </div>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="5" class="py-16">
                                    <div class="text-center">
                                        <div
                                            class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                            No Students Found
                                        </h3>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            No student records are available at the moment.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if ($students->hasPages())
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-800 pt-4">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Toast Notification Script -->
        @push('script')
            <script>
                window.addEventListener('student-saved', event => {
                    let data = event.detail;
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'font-["Open_Sans"]'
                        },
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: data.icon,
                        title: data.text
                    });
                });
            </script>
        @endpush
    </div>

    @include('partials.models.student_modal')
</div>
