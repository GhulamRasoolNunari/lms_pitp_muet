
<div x-data="{ showCourseForm: true }" class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-12">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-md dark:border-gray-800 dark:bg-dark-800">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white"> Upload Task</h2>
                <button @click="showCourseForm = !showCourseForm" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="save" enctype="multipart/form-data">
                @csrf

                <div x-show="showCourseForm" x-transition class="space-y-5">

                    <!-- Select Task -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Select Task
                        </label>
                        <select wire:model="task_id"
                            class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-dark-900 px-4 text-sm text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                            <option value="">-- Select Task --</option>
                            @foreach ($tasks as $task)
                                <option value="{{ $task->id }}">{{ $task->task_title }}</option>
                            @endforeach
                        </select>
                        @error('task_id')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Task Description
                        </label>
                        <textarea wire:model="description" rows="4" placeholder="Enter task details..."
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-dark-900 px-4 py-2 text-sm text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500 focus:outline-none"></textarea>
                        @error('description')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Attachment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Attachment File
                        </label>
                        <input type="file" wire:model="attachment_link"
                          onchange="if(this.files[0]?.size > 5242880){ alert('File must be under 5MB'); this.value=''; }"
                            class="w-full text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-dark-900 px-4 py-2 text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500 focus:outline-none" />
                        @error('attachment_link')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- file link -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            File link (file exceeds 5mb paste your drive link here)
                        </label>
                        <input type="text" wire:model="file_link"
                            class="w-full text-sm rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-dark-900 px-4 py-2 text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500 focus:outline-none" />
                        @error('file_link')
                            <span class="text-sm text-red-500">{{ z }}</span>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="text-right">
                        <button wire:loading.attr="disabled" wire:target="save" type="submit"
                                        class="inline-flex items-center gap-1 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">Submit Task
                                        <div wire:loading wire:target="save"
                                            class="w-4 h-4 animate-spin rounded-full border-2 border-solid border-white border-t-transparent">
                                        </div>
                        </button>
                    </div>

                </div>
            </form>
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