<?php

namespace Database\Factories;

use App\Models\StudentData;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentDataFactory extends Factory
{
    protected $model = StudentData::class;

    public function definition(): array
    {
        return [
            'student_number' => fake()->unique()->numerify('##########'),
            'major' => fake()->randomElement([
                'مهندسی کامپیوتر',
                'علوم کامپیوتر',
                'مهندسی برق',
                'مهندسی مکانیک',
            ]),
            'entry_year' => fake()->numberBetween(1390, 1402),
            'entry_term' => fake()->randomElement(['first', 'second']),
            'current_term' => fake()->numberBetween(1, 8),
            'current_year' => fake()->numberBetween(1390, 1402),
            'academic_status' => fake()->randomElement(['active', 'probation', 'suspended', 'graduated', 'withdrawn']),
        ];
    }
}
