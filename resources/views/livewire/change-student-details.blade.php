<div x-data="{ open: @entangle('show') }">
    <!-- backdrop -->
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/30 backdrop-blur-lg z-1000"></div>

    <!-- modal content -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 flex items-center justify-center z-1100">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg" @click.outside="open=false">
            <div class="flex justify-between">

                <h2 class="text-lg font-semibold mb-4">Change Students Essentials</h2>
                <h2 class="text-lg font-semibold mb-4 cursor-pointer" @click="open=false">
                    &times;
                </h2>
            </div>

            <div class="course-campus-batch flex gap-4">
                <!-- Campus Category -->
                <div class="my-3 w-1/2">
                    <!-- Label with Icon -->
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-1.2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13" />
                        </svg>
                        <span>Campus </span>
                    </label>

                    <!-- Input Field -->
                    <select wire:model.live="campus_id"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        <option value=""> Select Campus</option>
                        @foreach ($campuses as $campus)
                            <option value="{{ $campus->id }}">{{ $campus->title }}</option>
                        @endforeach

                    </select>
                    @error('campus_id')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Course Category -->
                <div class="my-3 w-1/2">
                    <!-- Label with Icon -->
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-1.5">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13" />
                        </svg>
                        <span>Batch </span>
                    </label>

                    <!-- Input Field -->
                    <select wire:model.live="batch_id" {{-- @if (empty($batches)) disabled @endif --}}
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Batches</option>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}">{{ $batch->title }}</option>
                        @endforeach
                    </select>
                    @error('batch_id')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="course-campus-batch flex gap-4">
                <!-- Batch Category -->
                <div class="my-3 w-1/2">
                    <!-- Label with Icon -->
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-1.5">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13" />
                        </svg>
                        <span>Course ID</span>
                    </label>

                    <!-- Input Field -->
                    <select wire:model="course_id"
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
                    @error('course_id')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Time Slot Category -->
                {{-- <div class="my-3 w-1/2">
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-1.5">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13" />
                        </svg>
                        <span>Time Slot </span>
                    </label>

                    <select wire:model="time_slot_id"
                        class="w-full h-11 rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        <option value="">Select Time slots</option>
                        @foreach ($timeSlots as $timeSlot)
                            <option value="{{ $timeSlot->id }}">{{ $timeSlot->title }}</option>
                        @endforeach
                    </select>
                    @error('time_slot_id')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div> --}}

            </div>

            <div class="parent flex justify-end">

                <button wire:click="save()"
                    class="px-6  py-3 rounded-2xl  bg-blue-600 text-white font-medium transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none font-['Open_Sans']"
                    wire:loading.attr="disabled">

                    <!-- Loading State -->
                    <div wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Saving...</span>
                    </div>

                    <!-- Default State -->
                    <div wire:loading.remove wire:target="save" class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9a3 3 0 11-6 0 3 3 0 016 0zM13.5 20.25h6M16.5 17.25v6M4.5 20.25v-1.5A4.5 4.5 0 019 14.25h3" />
                        </svg>
                        <span>Save</span>
                    </div>
                </button>
            </div>

        </div>
    </div>
</div>
