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
        Schema::create('course_campuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('course_id');
            $table->text('description')->nullable()->comment('Course Campus description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_campuses');
    }
};
