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
        Schema::create('student_test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')
            ->constrained('quizzes')
            ->onDelete('cascade');
            $table->foreignId('student_id')
            ->constrained('users')
            ->onDelete('cascade');
            $table->enum('test_started', ['0', '1'])->default('0');
            $table->enum('is_completed', ['0', '1'])->default('0');
            $table->time('test_timer')->default('00:00:00');
            $table->integer('questions_count')->default(0);
            $table->integer('wrong_ans')->default(0);
            $table->integer('correct_ans')->default(0);
            $table->float('percentage', 5, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_test_attempts');
    }
};
