<?php

namespace Database\Factories;

use App\Models\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserStatusFactory extends Factory
{
    protected $model = UserStatus::class;

    public function definition(): array
    {
        return [
            'min_unit' => fake()->numberBetween(12, 14),
            'max_unit' => fake()->numberBetween(18, 20),
            'passed_units' => fake()->numberBetween(0, 150),
            'loss_units' => fake()->numberBetween(0, 20),
            'unit_interm' => fake()->numberBetween(0, 6),
            'unit_intership' => fake()->numberBetween(0, 3),
            'free_unit' => fake()->numberBetween(0, 6),
            'pass_term' => fake()->numberBetween(0, 8),
            'take_listen' => fake()->randomElements([
                'مبانی کامپیوتر',
                'ریاضی عمومی',
                'فیزیک',
                'برنامه‌نویسی',
            ], 3),
            'allowed_term' => fake()->numberBetween(4, 8),
            'student_status' => fake()->randomElement(['active', 'probation', 'suspended', 'graduated', 'withdrawn']),
            'can_take_courses' => fake()->randomElement(['yes', 'no']),
            'academic_notes' => fake()->optional()->sentence(),
        ];
    }
}
