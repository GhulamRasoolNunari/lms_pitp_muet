<div x-data="{ showQuizForm: false, showGrabbedQuestion: false }" class="grid grid-cols-12 gap-4 md:gap-6 p-4">
    <!-- Create Course Section -->
    <div class="col-span-12 space-y-6">
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800/50 p-4 sm:p-6 shadow-sm">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white font-['Open_Sans']">
                    Create New Quiz
                </h3>
                <button @click="showQuizForm = !showQuizForm"
                    class="w-10 h-10 rounded-lg  bg-gradient-to-br from-slate-800 via-slate-900 to-black dark:from-slate-900 dark:via-black dark:to-slate-950 hover:from-gray-600 hover:to-gray-700 text-white flex items-center justify-center transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    aria-label="Toggle course creation form" title="Toggle Course Form">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 transition-transform duration-200"
                        :class="showQuizForm ? 'rotate-45' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
            </div>

            <!-- Form Section -->
            <form wire:submit.prevent="save">
                @csrf
                <div x-show="showQuizForm" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="space-y-4 mt-4">
                    <!-- Course Title -->
                    <div class="input-group">

                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Quiz Title
                        </label>
                        <input type="text" placeholder="Enter Title" wire:model="title"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        @error('title')
                            <span class="text-red-500 ms-2 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Course Description -->
                    <div class="input-group">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Quiz Description
                        </label>
                        <textarea placeholder="Enter a description..." rows="6" wire:model="description"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
                        @error('description')
                            <span class="text-red-500 ms-2 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Campus Batch Courses Select -->
                    <div class="both-group-merged flex gap-4 items-center">
                        <!-- Campuses -->
                        <div class="w-1/3  input-group">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Select Course ID
                            </label>
                            <select id="selcted_campus" wire:model="selectedCourseDetail"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800
                                dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-400">
                                <option value="">Select Course ID</option>
                                @foreach ($course_details as $course_detail)
                                    <option @selected($course_detail->id === $updatedCampusId) value="{{ $course_detail->id }}">
                                        {{ $course_detail->title }}</option>
                                @endforeach
                            </select>
                            @error('selectedCourseDetail')
                                <span class="text-red-500 ms-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Assign Group Select -->





                    </div>
                    {{-- Quiz Duration and Marks --}}
                    <div class="both-group-merged flex gap-4 items-center">
                        <!-- exam duration Select -->
                        <div class="w-1/3 input-group">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Quiz Duration
                            </label>
                            <input type="number" placeholder="Enter in Minutes" wire:model="duration"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            @error('duration')
                                <span class="text-red-500 ms-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- marks -->
                        <div class="w-1/3 input-group">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Marks
                            </label>
                            <input type="number" placeholder="Marks" wire:model="marks"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            @error('marks')
                                <span class="text-red-500 ms-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Date --}}
                        <div class="w-1/3 input-group">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Date
                            </label>
                            <input type="date" wire:model="for_date"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            @error('for_date')
                                <span class="text-red-500 ms-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div>
                        <button wire:loading.attr="disabled" wire:click="showQuestionTeacherWise" type="button"
                            class="inline-flex items-center gap-1 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">Step
                            2. Grab
                            Questions
                            <div wire:loading wire:target="showQuestionTeacherWise"
                                class="w-4 h-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
                            </div>
                        </button>
                        <p>
                            @error('selectedRows')
                                <span class="text-red-500 ms-2 mt-1">{{ $message }}</span>
                            @enderror
                        </p>
                    </div>

                    {{-- show teachers added questions  only --}}
                    <div x-data="{ showGrabbedQuestion: @entangle('showGrabbedQuestion') }">
                        <div x-show="showGrabbedQuestion" x-cloak x-transition>
                            @if ($teachersAddedQuestion)
                                <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                            All Questions
                                        </h3>
                                    </div>

                                </div>

                                <div class="w-full overflow-x-auto">
                                    <table class="min-w-full">
                                        <!-- table header start -->
                                        <thead>
                                            <tr class="border-gray-100 border-y dark:border-gray-800">
                                                <th class="py-3">
                                                    <div class="flex items-center">
                                                        <p
                                                            class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                            Select
                                                        </p>
                                                    </div>
                                                </th>
                                                <th class="py-3">
                                                    <div class="flex items-center">
                                                        <p
                                                            class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                            ID
                                                        </p>
                                                    </div>
                                                </th>
                                                <th class="py-3">
                                                    <div class="flex items-center">
                                                        <p
                                                            class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                            Question
                                                        </p>
                                                    </div>
                                                </th class="py-3">


                                            </tr>
                                        </thead>
                                        <!-- table header end -->

                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">


                                            @foreach ($teachersAddedQuestion as $question)
                                                <tr wire:key="row-{{ $question->id }}">
                                                    <td class="py-3">
                                                        <input type="checkbox" wire:model="selectedRows"
                                                            value="{{ $question->id }}"
                                                            class="form-checkbox w-5 text-brand-500 border border-gray-300 rounded-md" />
                                                    </td>
                                                    <td class="py-3">
                                                        <div class="flex items-center">
                                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                                {{ $loop->iteration }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="py-3">
                                                        <div class="flex items-center">
                                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                                {{ $question->question }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                    <button wire:loading.attr="disabled" wire:target="save" type="submit"
                        class="inline-flex items-center gap-1 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">Submit
                        <div wire:loading wire:target="save"
                            class="w-4 h-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Courses List Section -->
    <div class="col-span-12 space-y-6">
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800/50 p-4 sm:p-6 shadow-sm">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white font-['Open_Sans']">
                        All Quizzes
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Manage and view all courses
                    </p>
                </div>
                <div class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400 font-['Open_Sans']">
                        {{ $quizes->total() }} Courses
                    </span>
                </div>
            </div>

            <!-- Table Container -->
            <div class="w-full overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/30">
                        <tr>
                            <th scope="col"
                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                #
                            </th>
                            <th scope="col"
                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                Quiz Title
                            </th>
                            <th scope="col"
                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                Quiz Description
                            </th>
                            <th scope="col"
                                class="py-3.5 px-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($quizes as $quiz)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-200">
                                <td class="py-4 px-3">
                                    <span
                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-sm font-semibold text-blue-600 dark:text-blue-400 font-['Open_Sans']">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="py-4 px-3">
                                    <p class="font-semibold text-gray-800 dark:text-white font-['Open_Sans']">
                                        {{ $quiz->title }}
                                    </p>
                                </td>
                                <td class="py-4 px-3">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white font-['Open_Sans']">
                                        {{ $quiz->description }}
                                    </p>
                                </td>

                                <td class="py-4 px-3">
                                    <div class="flex items-center justify-center gap-3">
                                        <!-- Edit Button with Tooltip -->
                                        <div x-data="{ showTooltip: false }" class="relative">
                                            <button wire:click="edit({{ $quiz->id }})"
                                                @click="showQuizForm = true"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition"
                                                title="Edit Quiz">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.313l-4.5 1.125 1.125-4.5 12.737-12.45z" />
                                                </svg>
                                            </button>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <h3
                                            class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2 font-['Open_Sans']">
                                            No Courses Found
                                        </h3>
                                        <p class="text-gray-500 dark:placeholder-gray-400 font-['Open_Sans']">
                                            Get started by creating your first course.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($quizes->hasPages())
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        {{ $quizes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SweetAlert Confirmation -->
    <div x-data="{ open: false }" x-init="window.addEventListener('swal-confirm', () => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you really want to delete this course?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it',
            cancelButtonText: 'No, Cancel',
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#3b82f6',
            preConfirm: () => {
                @this.deleteCourse();
            }
        });
    })">
    </div>
</div>

@push('script')
    <script>
        window.addEventListener('quiz-saved', event => {
            let data = event.detail;
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            })
            Toast.fire({
                icon: data.icon,
                title: data.text
            });

        });
        window.addEventListener('course-deleted', event => {
            let data = event.detail;
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            })
            Toast.fire({
                icon: "success",
                title: data.text
            });

        });
    </script>
@endpush
