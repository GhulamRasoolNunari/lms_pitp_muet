<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_registers', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('father_name');

            $table->enum('gender', ['male', 'female', 'transgender']);
            $table->string('cnic_number')->unique();      // 13 digits (validated)
            $table->string('email')->unique();
            $table->string('contact_number');             // 11 digits (validated)
            $table->string('date_of_birth');              // keep as string per your current data

            // Files (store relative paths)
            $table->string('profile_picture');
            $table->string('intermediate_marksheet');
            $table->enum('domicile_category', ['urban', 'rural']);
            $table->string('domicile_form_c');

            $table->string('domicile_district');

            // Enrollment flags
            $table->boolean('enrolled_status')->default(false);

            // Education / University
            $table->string('most_recent_institution');               // you’re treating as required now
            $table->enum('highest_qualification', ['matric', 'intermediate', 'graduate']);       // NEW (e.g., Matric/Intermediate/etc.)

            // Preferences
            $table->string('preferred_study_center');
            $table->string('preferred_time_slot');

            // Courses
            $table->string('course_choice_1');
            $table->string('course_choice_2');
            $table->string('course_choice_3');
            $table->string('course_choice_4');

            // Disability
            $table->enum('have_disability', ['yes', 'no']);  // NEW (you store "yes"/"no")

            // Income
            $table->string('monthly_household_income');      // NEW (e.g., "Below PKR 25,000")

            // “Participated previously” flow
            $table->enum('participated_previously', ['yes', 'no']);  // NEW
            $table->string('course_if_participated')->nullable();     // NEW
            $table->string('phase_if_participated')->nullable();      // NEW
            $table->string('center_if_participated')->nullable();     // NEW

            // Source & confirmation
            $table->string('from_source');                   // NEW (e.g., 'other', 'facebook', etc.)
            $table->boolean('info_confirm')->default(false); // NEW (checkbox)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_registers');
    }
};
