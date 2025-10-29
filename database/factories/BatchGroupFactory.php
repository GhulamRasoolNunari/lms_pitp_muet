<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=BatchGroup>
 */
class BatchGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
           return [
            'course_id' => \App\Models\Course::factory(),
            'teacher_id' => \App\Models\User::factory()->state(['user_type' => 'teacher']),
            'from' => $this->faker->time('H:i:s'), // e.g., "07:46:00"
            'to' => $this->faker->time('H:i:s'),   // e.g., "10:30:00"
            'session_year_id' => \App\Models\CustomSession::factory(),
            'group_name' => 'Group ' . $this->faker->unique()->bothify('??-###'),
            'is_completed' => $this->faker->randomElement([0, 1]),
        ];
    }
}
