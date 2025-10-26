<div class="grid grid-cols-12 gap-4 md:gap-6">


    <div class="col-span-12 space-y-6 xl:col-span-12">
        <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
            <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Student Quiz List
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
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        Quiz
                                    </p>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        Quiz desc
                                    </p>
                                </div>
                            </th>


                            <th class="py-3">
                                <div class="flex items-center col-span-2">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        Status
                                    </p>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="flex items-center col-span-2">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        Action
                                    </p>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <!-- table header end -->

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($quizes as $quiz)
                            <tr>
                                <td class="py-3">
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $quiz->title }}
                                    </p>
                                </td>
                                <td class="py-3">
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $quiz->description }}
                                    </p>
                                </td>


                                <td class="py-3">
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $quiz->description }}
                                    </p>
                                </td>

                                <td class="py-3">
                                    <div class="flex items-center gap-2">
                                        <button wire:click="redirecToQuiz({{ $quiz->id }})" @click="showCourseForm = true"
                                            class="text-xs bg-blue-600 flex items-center text-white dark:text-white-400 p-3 rounded-sm"
                                            title="Edit">
                                            Start
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4 ml-0.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                            </svg>
                                        </button>

                                    </div>
                                </td>

            </div>
            </tr>
            @endforeach

        </div>
        </tbody>
        </table>
        <div class="mt-3">
            {{-- {{ $batches->links() }} --}}
        </div>
    </div>
</div>
{{-- <div x-data="{ open: false }" x-init="window.addEventListener('swal-confirm', () => {
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
                        @this.deleteCourse(); // Call Livewire method to delete the course
                    }
                });
            })"> --}}
@push('script')
    <script>
        window.addEventListener('batches-saved', event => {
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
    </script>
@endpush

</div>
