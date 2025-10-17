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
        Schema::create('course_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->integer('enroll_limit')->nullable();

            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('campus_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('time_slot_id')->nullable();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batcches')->onDelete('cascade');
            $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
