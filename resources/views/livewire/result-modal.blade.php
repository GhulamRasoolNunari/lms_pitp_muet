<div x-data="{ showMyResult: false }" x-on:show-result.window="showMyResult = true">
    <!-- Demo Button to trigger modal -->


    <!-- Modal Wrapper -->
    <div x-show="showMyResult" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[99999] flex items-center justify-center px-5 py-8  bg-transparent backdrop-blur-lg overflow-y-auto"
        x-cloak>
        <!-- Modal Box -->
        <div x-show="showMyResult" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            @click.outside="showMyResult = false"
            class="relative w-full max-h-screen max-w-xl rounded-2xl bg-white dark:bg-gray-900 p-8 shadow-lg border border-gray-200 dark:border-gray-700 overflow-y-auto">
            <!-- Close Button -->
            <button @click="showMyResult = false"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="space-y-6 text-gray-800 dark:text-white mt-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <!-- Wrong Answer -->
                    <div
                        class="rounded-xl bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 p-4 text-center shadow-sm">
                        <p class="text-sm font-medium text-red-700 dark:text-red-300">Wrong Answer</p>
                        <p class="mt-1 text-2xl font-bold text-red-800 dark:text-red-100">{{ $wrongAnswerCount }}</p>
                    </div>

                    <!-- Correct Answer -->
                    <div
                        class="rounded-xl bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 p-4 text-center shadow-sm">
                        <p class="text-sm font-medium text-green-700 dark:text-green-300">Correct Answer</p>
                        <p class="mt-1 text-2xl font-bold text-green-800 dark:text-green-100">
                            {{ $correctAnswerCount }}</p>
                    </div>

                    <!-- Total Questions -->
                    <div
                        class="rounded-xl bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 p-4 text-center shadow-sm">
                        <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Total Questions</p>
                        <p class="mt-1 text-2xl font-bold text-blue-800 dark:text-blue-100">
                            {{ $questionCount }}</p>
                    </div>
                </div>

                <!-- Question -->
{{-- 00-03-69-64 --}}
                @foreach ($resultModalData as $result)
                    <div>
                        <div class="flex items-center ">
                            <p class="text-lg font-medium  ">Q:{{ $loop->iteration }}
                            <div class="ms-3">
                                {!! $result->question->question !!} </div>
                            </p>
                        </div>
                        <div class="space-y-2 my-3">
                            <!-- Correct Answer -->
                            <button
                                class="w-full flex  px-4 py-3 rounded-lg border border-green-300 dark:border-green-600 bg-green-50 dark:bg-green-900 text-green-800 dark:text-green-200 text-left shadow-sm hover:shadow transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-[20px] me-3 text-green-600 dark:text-green-400">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                        clip-rule="evenodd" />
                                </svg> {{ $result->correct_answer }}
                            </button>

                            <!-- Wrong Answer -->
                            <button
                                class="w-full flex px-4 py-3 rounded-lg border border-red-300 dark:border-red-600 bg-red-50 dark:bg-red-900 text-red-800 dark:text-red-200 text-left shadow-sm hover:shadow transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-[20px] me-3 text-red-600 dark:text-red-400">
                                    <path fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                        clip-rule="evenodd" />
                                </svg> {{ $result->chosen_option }}
                            </button>
                        </div>
                    </div>
                @endforeach
                @if (count($resultModalData) <= 0)
                    <div>
                        <h5 class="text-xl text-red-600 text-center dark:text-gray-200">
                            No Incorrect Answers Found
                        </h5>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
