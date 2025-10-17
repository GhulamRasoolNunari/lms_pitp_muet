<div x-data="{ showCourseForm: false }" class="grid grid-cols-12 gap-4 md:gap-6 p-4">
    <!-- Create Course Section -->
    <div class="col-span-12 space-y-6">
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800/50 p-4 sm:p-6 shadow-sm">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white font-['Open_Sans']">
                    Create Task For Students
                </h3>
                <button @click="showCourseForm = !showCourseForm"
                    class="w-10 h-10 rounded-lg  bg-gradient-to-br from-slate-800 via-slate-900 to-black dark:from-slate-900 dark:via-black dark:to-slate-950 hover:from-gray-600 hover:to-gray-700 text-white flex items-center justify-center transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    aria-label="Toggle course creation form" title="Toggle Course Form">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 transition-transform duration-200"
                        :class="showCourseForm ? 'rotate-45' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
            </div>

            <!-- Form Section -->
            {{-- <form wire:submit.prevent="save" x-show="showCourseForm" x-cloak
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-6 space-y-6">
                @csrf --}}

            <form wire:submit.prevent="save"
                enctype="multipart/form-data"
                x-show="showCourseForm"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-6 space-y-6">
                @csrf



                <!-- Task Title -->
                <div class="space-y-2">
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 font-['Open_Sans'] flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Task Title
                    </label>
                    <input type="text" wire:model="task_title" placeholder="Enter Task title"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-['Open_Sans']"
                        aria-describedby="task_title-error">
                    @error('task_title')
                        <p id="task_title-error" class="text-red-500 text-sm mt-1 font-['Open_Sans']">{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Task Description -->
                <div class="space-y-2">
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 font-['Open_Sans'] flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Task Description
                    </label>
                    <textarea wire:model="task_description" placeholder="Enter task description"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-['Open_Sans']"
                        aria-describedby="task_description-error"></textarea>
                    @error('task_description')
                        <p id="task_description-error" class="text-red-500 text-sm mt-1 font-['Open_Sans']">
                            {{ $message }}</p>
                    @enderror
                </div>
                <!-- Select Course -->
                <div class="space-y-2">
                    <label for="course_id"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 font-['Open_Sans'] flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Select Course
                    </label>
                    <select id="course_id" wire:model="course_id"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-['Open_Sans']"
                        aria-describedby="batch-error">
                        <option value="">Select Course</option>
                        @foreach ($course_detail as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->course->title }}  <span class="text-sm"> - ({{ $item->batch->title }})</span>
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p id="course_id-error" class="text-red-500 text-sm mt-1 font-['Open_Sans']">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Number of Days -->
                {{-- <div class="space-y-2">
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 font-['Open_Sans'] flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 4h10M5 11h14M5 15h14M5 19h14" />
                        </svg>
                        Number of Days
                    </label>
                    <input type="number" wire:model="number_of_days" placeholder="Enter number of days"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-['Open_Sans']"
                        aria-describedby="number_of_days-error">
                    @error('number_of_days')
                        <p id="number_of_days-error" class="text-red-500 text-sm mt-1 font-['Open_Sans']">
                            {{ $message }}</p>
                    @enderror
                </div> --}}


                <div class="space-y-2">
                    <label
                        for="number_of_days"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 font-['Open_Sans'] flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 4h10M5 11h14M5 15h14M5 19h14" />
                        </svg>
                        Number of Days
                    </label>

                    <input
                        id="number_of_days"
                        type="number"
                        wire:model="number_of_days"
                        placeholder="Enter number of days"
                        min="1"
                        max="15"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-['Open_Sans']"
                        aria-describedby="number_of_days-error"
                    >

                    @error('number_of_days')
                        <p id="number_of_days-error" class="text-red-500 text-sm mt-1 font-['Open_Sans']">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                <!-- Total Marks -->
                <div class="space-y-2">
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 font-['Open_Sans'] flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                        </svg>
                        Total Marks
                    </label>
                    <input type="number" wire:model="total_marks" readonly placeholder="Enter total marks"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-['Open_Sans']"
                        aria-describedby="total_marks-error">
                    @error('total_marks')
                        <p id="total_marks-error" class="text-red-500 text-sm mt-1 font-['Open_Sans']">{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Attachment Upload -->
                {{-- <div class="space-y-2">
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 font-['Open_Sans'] flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 002.828 2.828L18 9.828m-1.414-1.414a4 4 0 00-5.656 0L5 14.172a4 4 0 105.656 5.656L20.485 9" />
                        </svg>
                        Attachment
                    </label>
                    <input type="file" wire:model.live="attachment_link"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-['Open_Sans']"
                        aria-describedby="attachment_link-error">
                    @error('attachment_link')
                        <p id="attachment_link-error" class="text-red-500 text-sm mt-1 font-['Open_Sans']">
                            {{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="space-y-2" wire:ignore.self>
                    <label
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 font-['Open_Sans'] flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 002.828 2.828L18 9.828m-1.414-1.414a4 4 0 00-5.656 0L5 14.172a4 4 0 105.656 5.656L20.485 9" />
                        </svg>
                        Attachment
                    </label>

                    <input type="file" wire:model="attachment_link"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 font-['Open_Sans']"
                        aria-describedby="attachment_link-error">

                    @error('attachment_link')
                        <p id="attachment_link-error" class="text-red-500 text-sm mt-1 font-['Open_Sans']">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                <!-- Submit Button -->
                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button wire:loading.attr="disabled" wire:target="save" type="submit"
                        class="group relative inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed font-['Open_Sans']"
                        aria-label="Create or update course">
                        <div wire:loading wire:target="save" class="flex items-center gap-2">
                            <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin">
                            </div>
                            <span>Creating Task...</span>
                        </div>
                        <div wire:loading.remove wire:target="save" class="flex items-center gap-2">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Create Task</span>
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
                        All Task
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Manage and view all Task
                    </p>
                </div>
                <div class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400 font-['Open_Sans']">
                        {{-- {{ $courses->total() }} Courses --}}
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
                                Task Title
                            </th>

                            <th class="py-3 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Days
                            </th>
                            <th class="py-3 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Marks</th>
                            <th class="py-3 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Attachment</th>
                            <th class="py-3 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Status</th>
                            <th scope="col"
                                class="py-3.5 px-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($teacherTasks as $teacherTask)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-200">
                                <td class="py-4 px-3">
                                    <span
                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-sm font-semibold text-blue-600 dark:text-blue-400 font-['Open_Sans']">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="py-4 px-3">

                                    {{ $teacherTask->task_title }}

                                </td>

                                <!-- Days -->
                                <td class="py-4 px-3 text-gray-700 dark:text-gray-300 text-sm font-['Open_Sans']">
                                    {{ $teacherTask->number_of_days }}
                                </td>

                                <!-- Marks -->
                                <td class="py-4 px-3 text-gray-700 dark:text-gray-300 text-sm font-['Open_Sans']">
                                    {{ $teacherTask->total_marks }}
                                </td>

                                <!-- Attachment -->
                                <td class="py-4 px-3">
                                    <div class="flex items-center justify-center">
                                        @if ($teacherTask->attachment_link)
                                            <a href="{{ asset('storage/attachments/' . $teacherTask->attachment_link) }}"
                                                target="_blank"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 hover:scale-105 transition-transform"
                                                title="Open Attachment">
                                                <!-- File Icon -->
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h10M7 11h10M7 15h6M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                                </svg>
                                            </a>
                                        @else
                                            <div class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600"
                                                title="No Attachment">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-4 0h4" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button wire:click="update_task({{ $teacherTask->id }})"
                                        @disabled($teacherTask->assigned_task == 1)
                                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full text-white shadow-md transition-all duration-300 ease-in-out transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:scale-100
                                            {{ $teacherTask->assigned_task == 1
                                                ? 'bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700'
                                                : 'bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700' }}"
                                        title="{{ $teacherTask->assigned_task == 1 ? 'Already Assigned' : 'Assign Task' }}">

                                        @if ($teacherTask->assigned_task == 1)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-300"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Assigned
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4l16 8-16 8V4z" />
                                            </svg>
                                            Assign
                                        @endif
                                    </button>


                                </td>
                                <td>
                                    <button wire:click="view_task({{ $teacherTask->id }})"
                                        class="inline-flex items-center text-sm text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                                        title="View Task">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <button wire:click="edit({{ $teacherTask->id }})" @click="showCourseForm = true"
                                        class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.313l-4.5 1.125 1.125-4.5 12.737-12.45z" />
                                        </svg>
                                    </button>

                                    <button wire:click="confirmDelete({{ $teacherTask->id }})"
                                        class="inline-flex items-center text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600"
                                        title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                clip-rule="evenodd" />
                                        </svg>


                                    </button>
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
                @if ($teacherTasks->hasPages())
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        {{ $teacherTasks->links() }}
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
    <div x-data="{ showTaskViewModal: false }" x-on:open-task-view-modal.window="showTaskViewModal = true" style="z-index: 99999">
        <!-- Modal -->
        <div x-show="showTaskViewModal" x-transition
            class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-50" style="display: none;">

            <!-- Background Overlay -->
            <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-sm"></div>

            <!-- Modal Content -->
            <div
                class="relative z-10 w-full max-w-4xl bg-white dark:bg-gray-900 rounded-3xl p-6 lg:p-10 shadow-xl max-h-[80vh] flex flex-col">

                <!-- Header with Fixed Close Button -->
                <div class="flex justify-between items-center mb-6 shrink-0">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white/90">Students Tasks</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            Total: <strong>{{ $submitedTasksCount }}</strong>
                        </span>
                        <button @click="showTaskViewModal = false; window.location.reload();"
                            class="text-gray-500 hover:text-black dark:hover:text-white text-xl font-bold z-20"
                            style="position: absolute; top: 1rem; right: 1rem;">
                            ×
                        </button>
                    </div>
                </div>

                <!-- Scrollable Table Content -->
                <div class="flex-1 overflow-y-auto p-0">
                    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-3">Students</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Attachment</th>
                                <th class="px-4 py-3">Students Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($submitedTasks as $task)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-3">{{ $task->user->full_name }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $showToggle = strlen($task->description) > 50;
                                        @endphp
                                        <div x-data="{ expanded: false }">
                                            <p class="text-sm text-gray-800 overflow-hidden text-ellipsis"
                                                :class="expanded ? '' : 'line-clamp-style'"
                                                style="display: -webkit-box; -webkit-box-orient: vertical;"
                                                x-text="expanded ? @js($task->description) : @js(Str::limit($task->description, 50))">
                                            </p>
                                            @if ($showToggle)
                                                <button @click="expanded = !expanded"
                                                    class="mt-1 text-blue-600 hover:underline text-xs font-medium">
                                                    <span x-show="!expanded">Show More</span>
                                                    <span x-show="expanded">Show Less</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($task->attachment_link)
                                            <a href="{{ asset('attachments/' . $task->attachment_link) }}"
                                                class="text-blue-500 underline" target="_blank">
                                                View
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <select
                                            x-on:change="$wire.marksUpdated($event.target.value, {{ $task->id }})"
                                            class="w-24 px-2 py-1 border rounded">
                                            <option value="">Select Marks</option>
                                            @for ($i = 0; $i <= 50; $i++)
                                                <option value="{{ $i }}" @selected($task->obtain_marks == $i)>
                                                    {{ $i }} Marks
                                                </option>
                                            @endfor
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Buttons -->
                <div class="mt-6 text-right shrink-0">
                    <button @click="showTaskViewModal = false; window.location.reload();"
                        class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        window.addEventListener('task-saved', event => {
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
        window.addEventListener('marks-saved', event => {
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
