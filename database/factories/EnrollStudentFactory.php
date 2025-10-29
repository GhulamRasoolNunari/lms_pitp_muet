<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnrollStudent>
 */
class EnrollStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id'            => User::factory()->student(), // creates a student user if not provided
            'father_name'           => $this->faker->name('male'),
            'gender'                => $this->faker->randomElement(['male', 'female']),
            'cnic_number'           => $this->faker->numerify('3###########'),
            'contact_number'        => $this->faker->numerify('03#########'),
            'date_of_birth'         => $this->faker->date('Y-m-d', '-18 years'),
            'profile_picture'       => $this->faker->name() . '.jpg',
            'intermediate_marksheet' =>  $this->faker->name() . '.png',
            'domicile_form_c'       =>  $this->faker->name() . '.jpeg',
            'domicile_district'     => $this->faker->city(),
            'university_name'       => $this->faker->company(),
        ];
    }
}
