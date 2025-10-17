<div class=" max-w-6xl mx-auto mt-2 space-y-8">

    <!-- Card 2: Question count + MCQ -->
    @if (!$testStarted)
        {{-- @if (!$testStarted) --}}
        {{-- @dd($quizRecord) --}}
        <div class=" min-h-screen flex items-center justify-center">
            <div class="my-3 bg-white shadow-2xl rounded-2xl max-w-3xl w-full p-8 md:p-12">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold">📝 Exam Instructions</h1>
                    <p class="text-gray-600 mt-2">Please read the instructions carefully before you begin.</p>
                </div>

                <div class="flex justify-between mb-8">
                    <h3 class="text-l text-gray-600 font-bold">User Name: <span
                            class="text-blue-500">{{ $user->full_name }}</span></h3>
                    <h3 class="text-l text-gray-600 font-bold">Selected Course: <span
                            class="text-blue-500">{{ $quizRecord->course->course_title }}</span></h3>
                </div>

                <!-- Instructions -->
                <div
                    class="bg-gray-100 border border-gray-50 p-6 rounded-xl space-y-3 text-gray-700 text-sm md:text-base">
                    <p>1. The exam consists of <strong>{{ $quizRecord->quiz_questions_count }} questions</strong> and
                        must be
                        completed within <strong>
                            {{-- {{ $totalTestTimeFromCourse }} --}}
                            {{ $quizRecord->duration }}
                            minutes</strong>.</p>
                    <p>2. Each correct answer awards <strong>1 mark</strong>. There is <strong>no negative
                            marking</strong>.</p>
                    <p>3. Do not refresh or close the browser tab during the exam.</p>
                    <p>4. Ensure a stable internet connection throughout the exam.</p>
                    <p>5. Questions will appear one by one and cannot be revisited.</p>
                    <p>6. Use only one device to take the exam.</p>
                </div>



                <!-- Action Buttons -->
                <div class="mt-8 flex justify-center gap-4">
                    <button wire:click="startTest"
                        class="bg-blue-400 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-600 transition duration-300">
                        Start Exam
                    </button>

                </div>
            </div>
        </div>
    @endif

    <!-- Main exam container with Alpine.js state for completion -->
    <div class="max-w-6xl mx-auto mt-2 space-y-8" x-data="{ completed: @entangle('isCompleted') }">
        {{-- @if ($testStarted && !$isCompleted && ($durationMinutes > 0 || $durationSeconds > 0)) --}}
        @if ($testStarted && !$isCompleted && ($durationMinutes > 0 || $durationSeconds > 0))
            <!-- Top bar with course name and timer -->
            <div class="flex items-center justify-between px-6 py-3 bg-white dark:bg-gray-800 rounded-xl shadow-md">
                <div class="text-xl font-semibold text-gray-800 dark:text-white">
                    <div>
                        {{ $user->student_details->course->course_title ?? 'Course Name' }}
                    </div>
                </div>
                <!-- Timer using Alpine.js quizTimer component -->
                <div x-data="quizTimer({{ $durationMinutes }}, {{ $durationSeconds }}, {{ $totalTestTimeInSeconds }})" x-init="start()" x-ref="timer" class="relative w-32 h-32">
                    <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 40 40">
                        <circle class="text-gray-300 dark:text-gray-600" stroke="currentColor" stroke-width="1"
                            fill="none" cx="20" cy="20" r="17" />
                        <circle :class="remainingTime <= 60 ? 'text-red-500' : 'text-blue-500'" stroke="currentColor"
                            stroke-width="1" fill="none" class="transition-colors duration-500"
                            stroke-linecap="round" cx="20" cy="20" r="17" stroke-dasharray="107"
                            :stroke-dashoffset="strokeDashoffset"
                            style="transform: rotate(-90deg); transform-origin: center;" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center text-center px-6 py-4">
                        <div x-text="remainingTime > 0 ? formattedTime : 'Time is up'"
                            class="text-lg font-semibold text-gray-800 dark:text-white leading-tight">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Question card -->
            <div class="py-6 px-8 bg-white dark:bg-gray-800 rounded-xl shadow-md"
                wire:key="question-{{ $currentIndex }}">
                <div class="flex items-center mb-6">
                    <div class="px-4 py-3 rounded-lg text-lg font-semibold text-blue-500">
                        {{-- @dd($quizRecord); --}}
                        Question {{ $currentIndex + 1 }} <span>out of</span> {{ $questionCount }}
                    </div>
                </div>
                <h2 class="mb-6 text-lg font-medium text-gray-800 dark:text-white">
                    {!! $currentQuestion->question !!}
                </h2>
                @error('studentSelectedOption')
                    <span class="text-red-500 ms-2 my-2 text-lg">{{ $message }}</span>
                @enderror
                <!-- Options list -->
                <div class="space-y-4">
                    @foreach (unserialize($currentQuestion->options) as $index => $option)
                        <label
                            class="flex items-center p-4 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <input type="radio" wire:model="studentSelectedOption" value="{{ $option }}"
                                class="form-radio text-blue-600 mr-4">
                            <span class="text-gray-700 dark:text-gray-200">{{ $option }}</span>
                        </label>
                    @endforeach
                </div>
                <!-- Submit button -->
                <div class="mt-6 text-right">
                    <button
                        x-on:click="Livewire.dispatch('setRemainingTime', { time: window.remainingTimeGlobal });$wire.submitAnswer()"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Submit
                    </button>
                </div>
            </div>
        @endif

        <section x-show="completed" x-transition.opacity.duration.500ms
            class="w-full h-full relative min-h-screen flex items-center justify-center p-4 ">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden border border-blue-100">

                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-6 text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold mb-2">Exam Completed</h1>
                    <p class="text-blue-100 text-sm">Results have been processed successfully</p>
                </div>

                <div class="p-8">
                    <!-- Student Information -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Student Name</p>
                                <p class="text-xl font-bold text-gray-900" id="studentName">{{ $user->full_name }}</p>
                            </div>
                        </div>

                        <!-- Exam Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <div>
                                    <span class="text-xs text-gray-500 block">Exam</span>
                                    <span class="font-semibold text-gray-900">{{ $quizRecord->title }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <span class="text-xs text-gray-500 block">Total Test Duration</span>
                                    <span class="font-semibold text-gray-900">{{ $durationMinutesForResultCard }}
                                        {{ $durationMinutesForResultCard >= '10' ? 'minutes' : 'minute' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-2 2m8-2l2 2m-2 6h.01M12 18h.01">
                                    </path>
                                </svg>
                                <div>
                                    <span class="text-xs text-gray-500 block">Submitted</span>
                                    <span class="font-semibold text-gray-900">{{ $testAttemptedDate }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                    </path>
                                </svg>
                                <div>
                                    <span class="text-xs text-gray-500 block">Status</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $resultPercentage >= 40 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                        "
                                        id="statusBadge">
                                        {{ $resultPercentage >= 40 ? 'PASSED' : 'FAILED' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-8"></div>

                    <!-- Score Section -->
                    <div class="mb-8">
                        <!-- Main Score Display -->
                        <div class="text-center mb-6">
                            <div class="text-6xl font-bold text-blue-600 mb-2">{{ $resultPercentage }}</div>
                            <p class="text-gray-600 text-lg">
                                <span id="correctCount">{{ $correctAnswerCount }}</span> out of
                                <span id="totalCount">{{ $questionCount }}</span> questions correct
                            </p>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-6">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Score Progress</span>
                                <span id="scoreRatio">{{ $correctAnswerCount }}/{{ $questionCount }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-1000 ease-out"
                                    style="width: {{ $resultPercentage }}"></div>
                            </div>
                        </div>

                        <!-- Performance Stats -->
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center p-4 bg-green-50 rounded-xl border border-green-100">
                                <div class="text-2xl font-bold text-green-600">{{ $correctAnswerCount }}</div>
                                <div class="text-sm text-green-700 font-medium">Correct</div>
                            </div>
                            <div class="text-center p-4 bg-red-50 rounded-xl border border-red-100">
                                <div class="text-2xl font-bold text-red-600">
                                    {{ $wrongAnswerCount }}
                                </div>
                                <div class="text-sm text-red-700 font-medium">Incorrect</div>
                            </div>
                            <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <div class="text-2xl font-bold text-blue-600">{{ $resultPercentage }}</div>
                                <div class="text-sm text-blue-700 font-medium">Score</div>
                            </div>
                        </div>
                    </div>

                    <!-- Result Message -->
                    <div
                        class="p-4 rounded-xl mb-8 text-center border {{ $resultPercentage >= 40 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                        <p class="font-semibold {{ $resultPercentage >= 40 ? 'text-green-800' : 'text-red-800' }}">
                            {{ $resultPercentage >= 40 ? ' Congratulations! You have successfully passed the exam.' : ' Keep studying! You can retake the exam to improve your score.' }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button wire:click="showResultModal"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            View Detailed Results
                        </button>

                        <button wire:click="exitToLogin"
                            class="bg-white hover:bg-gray-50 text-blue-600 font-semibold py-3 px-8 rounded-xl border-2 border-blue-200 hover:border-blue-300 transform hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                            </svg>
                            Return to Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('livewire.result-modal')
</div>
<script>
    function quizTimer(durationMin, durationSec, totalDurationInSec) {
        return {
            radius: 17,
            totalTime: totalDurationInSec,
            remainingTime: (durationMin * 60) + durationSec,
            interval: null,

            start() {
                this.interval = setInterval(() => {
                    if (this.remainingTime <= 0) {
                        clearInterval(this.interval);
                        this.remainingTime = 0;
                        Livewire.dispatch('setRemainingTime', {
                            time: window.remainingTimeGlobal
                        });
                        //Livewire.dispatch('autoSubmitWhenTimeUp');
                    } else {
                        this.remainingTime--;
                    }
                    window.remainingTimeGlobal = this.remainingTime;
                }, 1000);

                setInterval(() => {
                    if (typeof window.remainingTimeGlobal !== 'undefined') {
                        Livewire.dispatch('setRemainingTime', {
                            time: window.remainingTimeGlobal
                        });
                    }
                }, 10000);
            },

            get strokeDashoffset() {
                const circumference = 2 * Math.PI * this.radius;
                const elapsed = this.totalTime - this.remainingTime;
                const progress = elapsed / this.totalTime;
                return circumference * (1 - progress);
            },

            get formattedTime() {
                const m = Math.floor(this.remainingTime / 60);
                const s = this.remainingTime % 60;
                return `${m} mins - ${String(s).padStart(2, '0')} sec`;
            }
        }
    }
</script>
