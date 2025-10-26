<div x-data="{ showteacherForm: false }" class="grid grid-cols-12 gap-4 md:gap-6 p-4">
    <!-- Create teacher Section -->
    <div class="col-span-12 space-y-6">
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800/50 p-4 sm:p-6 shadow-sm">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white font-['Open_Sans']">
                    Create New Trainer
                </h3>
                <button @click="showteacherForm = !showteacherForm"
                    class="w-10 h-10 rounded-lg  bg-gradient-to-br from-slate-800 via-slate-900 to-black dark:from-slate-900 dark:via-black dark:to-slate-950 hover:from-gray-600 hover:to-gray-700 text-white flex items-center justify-center transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    aria-label="Toggle teacher creation form" title="Toggle teacher Form">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 transition-transform duration-200"
                        :class="showteacherForm ? 'rotate-45' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
            </div>

            <!-- Form Section -->

            <form wire:submit.prevent="save" x-show="showteacherForm" x-cloak
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-6 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Teacher Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13" />
                            </svg>
                            Trainer Name
                        </label>
                        <input type="text" wire:model="full_name" placeholder="Enter Trainer name"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        @error('full_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12A4 4 0 1 0 8 12a4 4 0 0 0 8 0zm0 0v1.5a2.5 2.5 0 0 0 5 0V12a9 9 0 1 0-18 0v1.5a2.5 2.5 0 0 0 5 0V12" />
                            </svg>
                            Email Address
                        </label>
                        <input type="email" wire:model="email" placeholder="Enter email address"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5h2l.4 2M7 13h10l1.4-6H6.6M7 13l-1 5h12l-1-5M9 21h6" />
                            </svg>
                            Phone Number
                        </label>
                        <input type="text" wire:model="phone" maxlength="11" placeholder="Enter phone number"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)">
                        @error('phone')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2" x-data="{ show: false }">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm6 0c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" />
                            </svg>
                            Password
                        </label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" wire:model="password" placeholder="Enter password"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700
                                   bg-white dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-800 dark:text-white
                                   placeholder:text-gray-400 dark:placeholder:text-white/30
                                   focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-50
                                   shadow-sm transition duration-150 ease-in-out">
                            <button type="button" @click="show = !show"
                                class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.944-9.544-7A10.042 10.042 0 015.636 6.36m3.157-1.47A9.964 9.964 0 0112 5c4.478 0 8.27 2.944 9.544 7a9.956 9.956 0 01-4.293 5.368M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button wire:loading.attr="disabled" wire:target="save" type="submit"
                        class="group relative inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200">
                        <div wire:loading wire:target="save" class="flex items-center gap-2">
                            <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin">
                            </div>
                            <span>Creating Trainer...</span>
                        </div>
                        <div wire:loading.remove wire:target="save" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Create Trainer</span>
                        </div>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Teacher List Section -->
    <div class="col-span-12 space-y-6">
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800/50 p-4 sm:p-6 shadow-sm">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <!-- Title -->
                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white/90 font-['Open_Sans']">
                        All Trainers
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Manage trainers information, edit details, and perform actions.
                    </p>
                </div>

                <!-- Total Count -->
                <div class="mt-3 sm:mt-0">
                    <div class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-lg inline-block">
                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                            {{ $teachers->total() }} Trainers
                        </span>
                    </div>
                </div>
            </div>

            <!-- Search Box (Below Table Heading) -->
            <div class="mt-6 mb-4">
                <input type="text" wire:model.live="search" placeholder="Search by name ,email and phone"
                    class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm
               focus:ring focus:ring-blue-200 focus:outline-none text-sm">
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
                                Name
                            </th>
                            <th scope="col"
                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                Email
                            </th>
                            <th scope="col"
                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                Phone
                            </th>

                            <th scope="col"
                                class="py-3.5 px-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($teachers as $teacher)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-200">
                                <td class="py-4 px-3">
                                    <span
                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-sm font-semibold text-blue-600 dark:text-blue-400 font-['Open_Sans']">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="py-4 px-3">
                                    <p class="font-semibold text-gray-800 dark:text-white font-['Open_Sans']">
                                        {{ $teacher->full_name }}
                                    </p>
                                </td>
                                <td class="py-4 px-3">
                                    <p class="font-semibold text-gray-800 dark:text-white font-['Open_Sans']">
                                        {{ $teacher->email }}
                                    </p>
                                </td>
                                <td class="py-4 px-3">
                                    <p class="font-semibold text-gray-800 dark:text-white font-['Open_Sans']">
                                        {{ $teacher->phone }}
                                    </p>
                                </td>

                                <td class="py-4 px-3">
                                    <div class="flex items-center justify-center gap-3">
                                        <!-- Edit Button with Tooltip -->
                                        <div x-data="{ showTooltip: false }" class="relative">
                                            <button wire:click="edit({{ $teacher->id }})"
                                                @click="showteacherForm = true" @mouseenter="showTooltip = true"
                                                @mouseleave="showTooltip = false"
                                                class="group relative inline-flex items-center justify-center w-9 h-9  text-blue-500 hover:bg-blue-500/10 rounded-full transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                                aria-label="Edit teacher {{ $teacher->title }}">
                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <div x-show="showTooltip"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-1"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-1"
                                                class="absolute z-10 bottom-full mb-2 left-1/2 transform -translate-x-1/2 px-3 py-1.5 bg-gray-900 text-white text-sm rounded-md shadow-md whitespace-nowrap">
                                                Edit teacher
                                            </div>
                                        </div>

                                        <!-- Delete Button with Tooltip -->
                                        {{-- <div x-data="{ showTooltip: false }" class="relative">
                                            <button
                                                wire:click="confirmDelete({{ $teacher->id }})"
                                                @mouseenter="showTooltip = true"
                                                @mouseleave="showTooltip = false"
                                                class="group relative inline-flex items-center justify-center w-9 h-9 text-red-500 hover:bg-red-500/10 rounded-full transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                                aria-label="Delete teacher {{ $teacher->title }}"
                                            >
                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <div
                                                x-show="showTooltip"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-1"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-1"
                                                class="absolute z-10 bottom-full mb-2 left-1/2 transform -translate-x-1/2 px-3 py-1.5 bg-gray-900 text-white text-sm rounded-md shadow-md whitespace-nowrap"
                                            >
                                                Delete teacher
                                            </div>
                                        </div> --}}
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
                                            No Trainers Found
                                        </h3>
                                        <p class="text-gray-500 dark:placeholder-gray-400 font-['Open_Sans']">
                                            Get started by creating your first trainers.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($teachers->hasPages())
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        {{ $teachers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SweetAlert Confirmation -->
    <div x-data="{ open: false }" x-init="window.addEventListener('swal-confirm', () => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you really want to delete this teacher?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it',
            cancelButtonText: 'No, Cancel',
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#3b82f6',
            preConfirm: () => {
                @this.deleteteacher();
            }
        });
    })">
    </div>
</div>

@push('script')
    <script>
        window.addEventListener('teacher-saved', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: event.detail.icon,
                title: event.detail.text
            });
        });

        window.addEventListener('teacher-deleted', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: 'success',
                title: event.detail.text
            });
        });
    </script>
@endpush
