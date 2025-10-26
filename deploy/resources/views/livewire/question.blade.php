<div x-data="{ showCourseForm: false }" class="grid grid-cols-12 gap-4 md:gap-6 p-4">
    <!-- Create Course Section -->
    <div class="col-span-12 space-y-6">
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800/50 p-4 sm:p-6 shadow-sm">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white font-['Open_Sans']">
                    Create Questions
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
            <form wire:submit.prevent="save">
                <div x-show="showCourseForm" x-transition class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm text-slate-600 dark:text-slate-300 mb-1">Title</label>
                        <input type="text" wire:model.defer="title"
                            class="w-full px-4 py-3 rounded-xl bg-white/30 dark:bg-slate-800/40 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" />
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Question -->
                    <div>
                        <label class="block text-sm text-slate-600 dark:text-slate-300 mb-1">Question</label>
                        <textarea wire:model.defer="question"
                            class="w-full h-32 px-4 py-3 rounded-xl bg-white/30 dark:bg-slate-800/40 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm resize-none"></textarea>
                        @error('question')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div x-data="questionFormComponent()" x-init="init(); window.addEventListener('question-saved', () => resetForm());"
                        x-on:edit-question-loaded.window="loadQuestion($event.detail)" class="space-y-4">

                        <input type="hidden" x-ref="optionsInput" wire:model.defer="options" />
                        <input type="hidden" x-ref="correctInput" wire:model.defer="correct_answer" />

                        <div class="flex items-center justify-between">
                            <h4 class="text-base font-semibold text-slate-700 dark:text-slate-200">Options</h4>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Mark one correct</span>
                        </div>

                        <template x-for="(answer, index) in options" :key="index">
                            <div class="flex items-center gap-4 p-3 bg-white/40 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 rounded-xl transition-all">
                                <input type="text" x-model="options[index]" @input="updateLivewire()"
                                    class="flex-1 px-4 py-2 rounded-lg bg-transparent text-slate-800 dark:text-white focus:outline-none" />
                                <div class="flex items-center gap-2">
                                    <input type="radio" :value="index" x-model="correct_answer" @change="updateLivewire()"
                                        class="text-blue-600 focus:ring-blue-500" />
                                    <span class="text-sm text-slate-600 dark:text-slate-300">Correct</span>
                                </div>
                                <button type="button" @click="removeOption(index)" x-show="options.length > 1"
                                    class="text-red-500 hover:bg-red-100 dark:hover:bg-red-900 p-1.5 rounded-full transition-all">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <button type="button" @click="addOption()"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm text-blue-600 bg-blue-50 dark:bg-blue-900/40 dark:text-blue-300 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                            + Add Option
                        </button>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-all shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg wire:loading wire:target="save" class="w-5 h-5 animate-spin"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                            </svg>
                            <span wire:loading.remove wire:target="save">Submit</span>
                        </button>
                    </div>
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
                        All Questions
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Manage and view all your questions here.
                    </p>
                </div>
                <div class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400 font-['Open_Sans']">
                        {{ $questions->total() }} Questions
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
                                Title
                            </th>
                            <th class="py-3 px-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Questions</th>
                            <th scope="col"
                                class="py-3.5 px-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 font-['Open_Sans']">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($questions as $question)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-200">
                                <td class="py-4 px-3">
                                    <span
                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-sm font-semibold text-blue-600 dark:text-blue-400 font-['Open_Sans']">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="py-4 px-3">

                                    {{ $question->title }}

                                </td>

                                <!-- Questions -->
                                <td class="py-4 px-3 text-gray-700 dark:text-gray-300 text-sm font-['Open_Sans']">
                                    {!! $question->question !!}
                                </td>
                                <td class="py-4 px-3 text-gray-700 dark:text-gray-300 text-sm font-['Open_Sans']">
                                    <button wire:click="edit({{ $question->id }})" @click="showCourseForm = true"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.313l-4.5 1.125 1.125-4.5 12.737-12.45z" />
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
                                            No Questions Found
                                        </h3>
                                        <p class="text-gray-500 dark:placeholder-gray-400 font-['Open_Sans']">
                                            Get started by creating your first Question.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($questions->hasPages())
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        {{ $questions->links() }}
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
        window.addEventListener('question-saved', event => {
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
        window.addEventListener('question-deleted', event => {
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


        function questionFormComponent() {
            return {
                options: [],
                correct_answer: '',
                //  showCourseForm: false, // colon, not equal sign

                init() {
                    this.$watch('options', () => this.updateLivewire());
                    this.$watch('correct_answer', () => this.updateLivewire());
                },

                loadQuestion(data) {
                    this.options = (typeof data.options === 'string') ?
                        JSON.parse(data.options).map(opt => opt.trim()) :
                        (data.options || ['']);

                    this.correct_answer = this.options.indexOf((data.correct_answer || '').trim());
                    if (this.correct_answer === -1) this.correct_answer = ''; // no correct answer selected

                    this.updateLivewire();
                },

                updateLivewire() {
                    this.$refs.optionsInput.value = JSON.stringify(this.options);
                    // store correct answer text, not index
                    this.$refs.correctInput.value = this.options[this.correct_answer] || '';
                    this.$refs.optionsInput.dispatchEvent(new Event('input'));
                    this.$refs.correctInput.dispatchEvent(new Event('input'));
                },

                addOption() {
                    this.options.push('');
                    this.updateLivewire();
                },

                removeOption(index) {
                    if (index === this.correct_answer) {
                        this.correct_answer = '';
                    } else if (index < this.correct_answer) {
                        this.correct_answer -= 1; // adjust index if needed
                    }
                    this.options.splice(index, 1);
                    this.updateLivewire();
                },
                resetForm() {
                    this.options = [''];
                    this.correct_answer = null;
                    this.updateLivewire();
                }
            }
        }
    </script>
@endpush
