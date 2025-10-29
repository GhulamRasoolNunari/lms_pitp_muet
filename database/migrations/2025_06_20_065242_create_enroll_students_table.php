<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enroll_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('father_name');
            $table->string('gender');
            $table->string('cnic_number');
            $table->string('contact_number');
            $table->date('date_of_birth');
            $table->string('profile_picture');
            $table->string('intermediate_marksheet');
            $table->string('domicile_form_c');
            $table->string('domicile_district');
            $table->string('university_name')->nullable();
            $table->tinyInteger('cancel_enrollment')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enroll_students');
    }
};
