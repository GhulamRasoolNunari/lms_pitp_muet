<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=StudentDetail>
 */
class StudentDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'teacher_id' => \App\Models\User::factory(),
        'group_id' => \App\Models\BatchGroup::factory(),
        'course_id' => \App\Models\Course::factory(),
        'entry_test' => $this->faker->boolean,
        'suspend_date' => $this->faker->optional()->date(),
        'reason_suspend' => $this->faker->optional()->sentence(),
        'is_completed' => $this->faker->randomElement(['0', '1']),
        'result' => $this->faker->randomElement(['In_progress', 'pass', 'fail']),
        'test_countdown' => $this->faker->numberBetween(0, 3600),
    ];
    }
}
