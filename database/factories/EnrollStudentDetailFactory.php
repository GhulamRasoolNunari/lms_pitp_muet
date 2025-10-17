<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnrollStudentDetail>
 */
class EnrollStudentDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => User::factory()->student(),
            'campus_id'  => 1,   // adjust if you have seeded campuses
            'batch_id'   => 1,   // adjust if you have seeded batches
            'course_id'  => 1,   // << keep static as requested
        ];
    }
    public function forStudent(int $userId): static
    {
        return $this->state(fn() => ['student_id' => $userId]);
    }
}
