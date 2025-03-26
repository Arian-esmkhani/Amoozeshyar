<?php

namespace Database\Factories;

use App\Models\UserGpa;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserGpaFactory extends Factory
{
    protected $model = UserGpa::class;

    public function definition(): array
    {
        return [
            'semester_gpa' => fake()->randomFloat(2, 0, 20),
            'last_gpa' => fake()->randomFloat(2, 0, 20),
            'cumulative_gpa' => fake()->randomFloat(2, 0, 20),
            'major_gpa' => fake()->randomFloat(2, 0, 20),
            'general_gpa' => fake()->randomFloat(2, 0, 20),
            'total_units' => fake()->numberBetween(0, 150),
            'passed_listen' => fake()->randomElements([
                'مبانی کامپیوتر',
                'ریاضی عمومی',
                'فیزیک',
                'برنامه‌نویسی',
            ], 3),
            'academic_status' => fake()->randomElement(['active', 'probation', 'suspended', 'graduated', 'withdrawn']),
        ];
    }
}
