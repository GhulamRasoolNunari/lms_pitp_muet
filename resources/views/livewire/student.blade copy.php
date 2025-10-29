<div x-data="{ tab: 'personal' }" class="max-w-3xl mx-auto bg-white shadow rounded-lg">
    <!-- Tabs Header -->
    <div class="border-b border-gray-200 flex space-x-4 p-4">
        <template
            x-for="(label, key) in { personal: 'Personal Details', education: 'Education', courses: 'Select Courses' }"
            :key="key">
            <button @click="tab = key" x-text="label"
                :class="tab === key ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-600 hover:text-blue-500'"
                class="px-3 py-2 font-medium border-b-2 transition"></button>
        </template>
    </div>

    <!-- Tabs Content -->
    <div class="relative p-8 m-6 ">
        <!-- Personal Details Tab -->
        <template x-if="tab === 'personal'">
            <div x-transition:enter="transition-opacity ease-out duration-500" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-400"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0"
                x-cloak>
                <h2 class="text-lg font-semibold mb-4">Personal Details</h2>
                <form class="space-y-4">
                    <!-- Full Name -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Name (as written on CNIC/B Form/Marksheet) <span
                                class="text-red-500">*</span></label>
                        <input type="text" placeholder="Enter name"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- Father's Name -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Father's Name <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Enter name"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- Gender -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- CNIC Number -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">CNIC Number (without dashes) <span
                                class="text-red-500">*</span></label>
                        <input type="text" placeholder="Your CNIC"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- Contact Number -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Contact Number (WhatsApp) <span
                                class="text-red-500">*</span></label>
                        <input type="text" placeholder="Your Contact"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- Date of Birth -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Date of Birth (as written on CNIC) <span
                                class="text-red-500">*</span></label>
                        <input type="date" placeholder="mm/dd/yyyy"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- Profile Picture -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Profile Picture (passport size, max file size 1 MB) <span
                                class="text-red-500">*</span></label>
                        <input type="file" accept="image/*"
                            class="file:mr-4 file:py-2 file:px-4 cursor-pointer
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100
                                        block w-full text-sm text-gray-700 border border-gray-300 rounded-lg bg-white focus:outline-none" />
                    </div>
                </form>
            </div>
        </template>

        <!-- Education -->
        <!-- Education -->
        <template x-if="tab === 'education'">
            <div x-transition:enter="transition-opacity ease-out duration-500" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-400"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0"
                x-cloak>
                <h2 class="text-lg font-semibold mb-4">Education</h2>
                <form class="space-y-4">
                    <!-- Highest Qualification -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Highest Qualification</label>
                        <input type="text" placeholder="Bachelor's Degree"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- University -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">University</label>
                        <input type="text" placeholder="University Name"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- Upload Intermediate/Equivalent (HSC-II) Marksheet or Pakka -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Upload Intermediate/Equivalent (HSC-II) Marksheet or Pakka
                            <span class="text-red-500">*</span></label>
                        <input type="file" accept="image/*,application/pdf"
                            class="file:mr-4 file:py-2 file:px-4 cursor-pointer
                           file:rounded-lg file:border-0
                           file:text-sm file:font-semibold
                           file:bg-blue-50 file:text-blue-700
                           hover:file:bg-blue-100
                           block w-full text-sm text-gray-700 border border-gray-300 rounded-lg bg-white focus:outline-none" />
                    </div>

                    <!-- Upload Your Domicile or Form C (maximum file size is 1 mb) -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Upload Your Domicile or Form C (maximum file size is 1 MB)
                            <span class="text-red-500">*</span></label>
                        <input type="file" accept="image/*,application/pdf"
                            class="file:mr-4 file:py-2 file:px-4 cursor-pointer
                           file:rounded-lg file:border-0
                           file:text-sm file:font-semibold
                           file:bg-blue-50 file:text-blue-700
                           hover:file:bg-blue-100
                           block w-full text-sm text-gray-700 border border-gray-300 rounded-lg bg-white focus:outline-none" />
                    </div>

                    <!-- Domicile District -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Domicile District <span class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select District</option>
                            <option value="district1">District 1</option>
                            <option value="district2">District 2</option>
                            <option value="district3">District 3</option>
                        </select>
                    </div>

                    <!-- Are you currently admitted/enrolled/studying in university? -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Are you currently admitted/enrolled/studying in university?
                            <span class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select Option</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <!-- If yes, write the name of the university/institute in which you are currently studying? -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">If yes, write the name of the university/institute in which
                            you
                            are
                            currently studying? <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="University/Institute Name"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- Your Contact -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Your Contact <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Your Contact"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden" />
                    </div>

                    <!-- Your preferred center for study -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Your preferred center for study? <span
                                class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select Center</option>
                            <option value="center1">Center 1</option>
                            <option value="center2">Center 2</option>
                            <option value="center3">Center 3</option>
                        </select>
                    </div>

                    <!-- Your preferred time slot -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">Your preferred time slot. <span
                                class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select Time Slot</option>
                            <option value="morning">Morning</option>
                            <option value="afternoon">Afternoon</option>
                            <option value="evening">Evening</option>
                        </select>
                    </div>
                </form>
            </div>
        </template>


        <!-- Courses Tab -->
        <template x-if="tab === 'courses'">
            <div x-transition:enter="transition-opacity ease-out duration-500" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-400"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0"
                x-cloak>
                <h2 class="text-lg font-semibold mb-4">Courses</h2>
                <form class="space-y-4">
                    <!-- 1st Choice -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">1st Choice <span class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select Course</option>
                            <option value="course1">Course 1</option>
                            <option value="course2">Course 2</option>
                            <option value="course3">Course 3</option>
                        </select>
                    </div>

                    <!-- 2nd Choice -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">2nd Choice <span class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select Course</option>
                            <option value="course1">Course 1</option>
                            <option value="course2">Course 2</option>
                            <option value="course3">Course 3</option>
                        </select>
                    </div>

                    <!-- 3rd Choice -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">3rd Choice <span class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select Course</option>
                            <option value="course1">Course 1</option>
                            <option value="course2">Course 2</option>
                            <option value="course3">Course 3</option>
                        </select>
                    </div>

                    <!-- 4th Choice -->
                    <div class="flex flex-col space-y-1">
                        <label class="text-sm font-medium">4th Choice <span class="text-red-500">*</span></label>
                        <select
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden">
                            <option value="">Select Course</option>
                            <option value="course1">Course 1</option>
                            <option value="course2">Course 2</option>
                            <option value="course3">Course 3</option>
                        </select>
                    </div>
                </form>
            </div>
        </template>
    </div>
</div>