<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     public function definition(): array
    {
        return [
            'title' => $this->faker->word, // fallback if used dynamically
            'description' => $this->faker->sentence,
        ];
    }

    public function predefinedCourses(): array
    {
        return [
            ['title' => 'Certified Cloud Computing Professional', 'description' => 'CSE'],
            ['title' => 'Certified Cyber Security and Ethical Hacking Professional', 'description' => 'Learn Cyber Security & EH: master network security, penetration testing, malware analysis, and defense strategies. Build skills to protect systems, prevent attacks, and ensure data safety.'],
            ['title' => 'Certified Data Scientist', 'description' => 'Master data science: learn Python, statistics, data analysis, visualization, and machine learning. Gain skills to extract insights, build predictive models, and solve real-world business problems.'],
            ['title' => 'Certified Database Administrator', 'description' => 'Master database administration: learn setup, configuration, backup, recovery, security, and tuning. Build skills to manage MySQL, Oracle, or PostgreSQL for efficient and secure data management.'],
            ['title' => 'Certified Digital Marketing Professional', 'description' => 'Learn digital marketing: SEO, social media, content, email, and ads. Build skills to boost brand visibility, drive traffic, and grow business online with effective marketing strategies.'],
            ['title' => 'Certified E-Commerce Professional', 'description' => 'Learn e-commerce essentials: store setup, product listings, payments, shipping, and marketing. Build skills to launch, manage, and grow a successful online business.'],
            ['title' => 'Certified Graphic Designer', 'description' => 'Learn graphic design basics: color theory, typography, branding, and digital tools. Gain creative skills to design logos, posters, and social media content for professional use.'],
            ['title' => 'Certified Java Developer', 'description' => 'Learn Java from basics to advanced: OOP, data structures, multithreading, JDBC, and APIs. Gain hands-on skills to build scalable apps and enterprise solutions. Perfect for beginners to professionals.'],
            ['title' => 'Certified Mobile Application Developer', 'description' => 'Mobile App Development 12 to 3'],
            ['title' => 'Certified Python Developer', 'description' => 'Lab 2, Department of Software Engineering, MUET'],
            ['title' => 'Certified Social Media Manager', 'description' => 'Lab 3, Department of Software Engineering, MUET'],
            ['title' => 'Certified Web Developer', 'description' => 'Learn web development: HTML, CSS, JavaScript, and frameworks. Build responsive websites, dynamic apps, and user-friendly interfaces. Gain skills to create and manage modern web solutions.'],
        ];
    }
}
