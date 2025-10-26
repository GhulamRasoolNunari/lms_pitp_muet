<?php

namespace Database\Factories;

use App\Models\StudentRegister;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentRegisterFactory extends Factory
{
    protected $model = StudentRegister::class;

    public function definition(): array
    {
        $faker = $this->faker;

        return [
            'full_name' => $faker->name(),
            'father_name' => $faker->name('male'),
            'gender' => $faker->randomElement(['male', 'female', 'transgender']),
            'cnic_number' => $faker->unique()->numerify('###########'), // 13 digits
            'email' => $faker->unique()->safeEmail(),
            'contact_number' => $faker->numerify('03#########'), // 11 digits
            'date_of_birth' => $faker->date('Y-m-d', '-18 years'),

            // files (just fake paths)
            'profile_picture' => 'uploads/profiles/' . Str::random(10) . '.jpg',
            'intermediate_marksheet' => 'uploads/marksheets/' . Str::random(10) . '.pdf',

            'domicile_category' => $faker->randomElement(['urban', 'rural']),
            'domicile_form_c' => 'FORMC-' . $faker->unique()->numberBetween(1000, 9999),
            'domicile_district' => $faker->city(),

            'enrolled_status' => $faker->boolean(),

            'most_recent_institution' => $faker->company(),
            'highest_qualification' => $faker->randomElement(['matric', 'intermediate', 'graduate']),

            'preferred_study_center' => $faker->city(),
            'preferred_time_slot' => $faker->randomElement(['Morning', 'Evening', 'Weekend']),

            'course_choice_1' =>'Certified Cloud Computing Professional',
            'course_choice_2' => 'Course ' . $faker->numberBetween(1, 10),
            'course_choice_3' => 'Course ' . $faker->numberBetween(1, 10),
            'course_choice_4' => 'Course ' . $faker->numberBetween(1, 10),

            'have_disability' => $faker->randomElement(['yes', 'no']),
            'monthly_household_income' => $faker->randomElement([
                'Below PKR 25,000',
                'PKR 25,000 - 50,000',
                'PKR 50,000 - 100,000',
                'Above PKR 100,000',
            ]),

            'participated_previously' => $faker->randomElement(['yes', 'no']),
            'course_if_participated' => $faker->optional()->word(),
            'phase_if_participated' => $faker->optional()->word(),
            'center_if_participated' => $faker->optional()->city(),

            'from_source' => $faker->randomElement(['facebook', 'twitter', 'instagram', 'friend', 'other']),
            'info_confirm' => $faker->boolean(),
        ];
    }
}
