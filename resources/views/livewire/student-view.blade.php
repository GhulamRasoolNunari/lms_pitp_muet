<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 md:col-span-6 space-y-2">

        <select wire:model.live="course_id"
            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
            aria-describedby="batch-error">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->campus->title }} - {{ $course->course->title }} <span class="text-sm"> - ({{ $course->batch->title }})</span></option>
            @endforeach
        </select>
    </div>

    <div class="col-span-12 space-y-6 xl:col-span-12">

        <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">

            <!-- Header Section -->
            <div class="flex flex-col gap-2 mb-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white/90 font-['Open_Sans']">
                        Students
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Manage student enrollment and view details
                    </p>
                </div>

                <!-- Optional: Add search or filter here -->
                <div class="flex items-center gap-3">
                    <div class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                            @if (!empty($students) && $students->count())
                                {{ $students->total() }} Students
                            @endif
                        </span>
                    </div>
                </div>
            </div>

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
                                     Name
                                </p>
                            </th>
                            {{-- <th class="py-4 px-3 text-left">
                                <p class="font-semibold text-gray-600 text-sm dark:text-gray-300 font-['Open_Sans']">
                                    Email
                                </p>
                            </th> --}}
                            <th class="py-4 px-3 text-left">
                                <p class="font-semibold text-gray-600 text-sm dark:text-gray-300 font-['Open_Sans']">
                                    Batch
                                </p>
                            </th>
                            <th class="py-4 px-3 text-left">
                                <p class="font-semibold text-gray-600 text-sm dark:text-gray-300 font-['Open_Sans']">
                                    Courses
                                </p>
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($students as $enrolled)

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
                                            {{ $enrolled->student->student->full_name }}
                                        </p>
                                        <p class="text-sm text-blue-600 dark:text-blue-400 lowercase">
                                            {{ $enrolled->student->student->email }}
                                        </p>
                                    </div>
                                </td>

                                <td class="py-4 px-3">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-gray-800 dark:text-white font-['Open_Sans']">
                                            {{ $enrolled?->batch?->title }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-4 px-3">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-gray-800 dark:text-white font-['Open_Sans']">
                                            {{ $enrolled?->course?->title }}
                                        </p>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
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
                @if (!empty($students) && $students->count())
                    <!-- Pagination -->
                    @if ($students->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-800 pt-4">
                            {{ $students->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    

</div>
