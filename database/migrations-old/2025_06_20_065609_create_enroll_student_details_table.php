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
        Schema::create('enroll_student_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('time_slot_id');
            $table->unsignedBigInteger('course_detail_id');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enroll_student_details');
    }
};
