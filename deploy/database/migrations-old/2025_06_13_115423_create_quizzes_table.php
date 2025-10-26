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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('Quiz title');
            $table->text('description')->nullable()->comment('Quiz description');
            $table->unsignedBigInteger('course_detail_id');
            $table->date('for_date');
            $table->time('duration')->comment('Test Duration');
            $table->unsignedBigInteger('marks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
