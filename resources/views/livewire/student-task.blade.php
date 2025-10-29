<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($tasks as $task)
        <div
            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 h-80 flex flex-col overflow-hidden group">

            <!-- Header -->
            <div class="flex justify-between items-start mb-4 px-5 pt-5">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white truncate">
                    {{ $task->task_title }}
                </h2>
                <span
                    class="px-3 py-1 rounded-full text-xs font-semibold transition-colors duration-300
                {{ $task->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($task->status) }}
                </span>
            </div>

            <!-- Marks -->
            <div class="bg-blue-50 dark:bg-blue-800/30 mx-5 rounded-xl px-4 py-2 mb-3">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Marks</span>
                    </div>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">
                        {{ @$task->task_marks->obtain_marks ?? 0 }} / {{ $task->total_marks }}
                    </span>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto px-5">
                @if ($task->remaining_time == 'The task date has passed')
                    <div class="bg-red-50 dark:bg-red-800/20 p-4 rounded-xl flex items-center justify-center h-full">
                        <p class="text-red-600 dark:text-red-300 font-semibold text-center">
                            The task date has passed
                        </p>
                    </div>
                @else
                    <div class="space-y-3">
                        <!-- Date Section -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl">
                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-1 mb-1 text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Assigned
                                    </div>
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($task->assigned_time)->format('Y-m-d') }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-1 mb-1 text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Due
                                    </div>
                                    <div class="font-medium text-red-600 dark:text-red-400">
                                        {{ \Carbon\Carbon::parse($task->due_time)->format('Y-m-d') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($task->assigned_time)->format('h:i A') }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($task->due_time)->format('h:i A') }}
                                </div>
                            </div>
                        </div>

                        <!-- Time Left or Submitted -->
                        <div
                            class="
                            p-3 rounded-xl flex justify-between items-center text-sm
                            {{ $task->is_submitted
                                ? 'bg-green-50 dark:bg-green-800/30 text-green-700 dark:text-green-300'
                                : 'bg-yellow-50 dark:bg-yellow-800/30 text-yellow-800 dark:text-yellow-200' }}
                        ">
                            @if ($task->is_submitted)
                                <div class="flex items-center gap-2 text-green-700 dark:text-green-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-semibold">Task Submitted</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-yellow-800 dark:text-yellow-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">Time Left</span>
                                </div>
                                <span class="font-semibold text-yellow-800 dark:text-yellow-200">
                                    {{ $task->remaining_time }}
                                </span>
                            @endif
                        </div>


                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="flex justify-between items-center px-5 pb-4 mt-auto">
                {{-- Left side: status --}}
                @if ($task->is_submitted)
                    <span class="text-xs font-semibold text-green-600 dark:text-green-400 flex items-center gap-1">

                    </span>
                @elseif ($task->remaining_time == 'The task date has passed')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold">
                        Task Expired
                    </span>
                @else
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $task->number_of_days }} days task
                    </span>
                @endif

                {{-- Right side: action button --}}
                <button wire:click="view_task({{ $task->id }})" aria-label="View Task"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 active:bg-blue-700 focus:ring focus:ring-blue-300 text-white text-sm font-medium rounded-xl transition duration-200">
                    View Task
                </button>
            </div>
        </div>
    @endforeach
    <div x-data="{ showTaskViewModal: false }" x-on:open-task-view-modal.window="showTaskViewModal = true" class="z-[99999]">

        <!-- Modal Backdrop -->
        <div x-show="showTaskViewModal" x-transition class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
            style="display: none;"></div>

        <!-- Modal -->
        <div x-show="showTaskViewModal" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6 py-8 overflow-y-auto"
            style="display: none;">

            <!-- Modal Content -->
            <div @click.outside="showTaskViewModal = false"
                class="relative w-full max-w-3xl bg-white dark:bg-gray-900 rounded-xl p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">

                <!-- Header -->
                <div
                    class="flex justify-between items-start sm:items-center border-b pb-4 mb-6 flex-col sm:flex-row gap-2">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                        📂 Task Detail
                    </h2>

                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                            ⏳ Duration: {{ $number_of_days }} day(s)
                        </span>

                        <button @click="showTaskViewModal = false"
                            class="text-2xl text-gray-400 hover:text-red-600 dark:hover:text-red-400 font-bold leading-none">
                            &times;
                        </button>
                    </div>
                </div>


                <!-- Task Info -->
                <div class="space-y-5 text-gray-800 dark:text-gray-200 text-sm sm:text-base">

                    <div>
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300">📌 Task Title:</h3>
                        <p class="mt-1">{{ $task_title }}</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300">📝 Description:</h3>
                        <p class="mt-1 whitespace-pre-line leading-relaxed">{{ $task_description }}</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300">📎 Attachment:</h3>
                        @if ($attachment_link)
                            <a href="{{ asset('attachments/' . $attachment_link) }}" target="_blank"
                                class="mt-1 inline-block text-blue-600 dark:text-blue-400 hover:underline">
                                🔗 View Attachment
                            </a>
                        @else
                            <p class="mt-1 italic text-gray-500">No attachment available.</p>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-right">
                    <button @click="showTaskViewModal = false"
                        class="px-6 py-2 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>
