<?php

namespace Database\Factories;

use App\Models\LestenOffered;
use Illuminate\Database\Eloquent\Factories\Factory;

class LestenOfferedFactory extends Factory
{
    protected $model = LestenOffered::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+6 months');
        $endDate = fake()->dateTimeBetween($startDate, '+6 months');

        return [
            'lesten_id' => fake()->unique()->numberBetween(1, 1000),
            'lesten_name' => fake()->randomElement([
                'مبانی کامپیوتر',
                'ریاضی عمومی',
                'فیزیک',
                'برنامه‌نویسی',
                'مدار منطقی',
                'ساختمان داده',
            ]),
            'major' => fake()->randomElement([
                'مهندسی کامپیوتر',
                'علوم کامپیوتر',
                'مهندسی برق',
                'مهندسی مکانیک',
            ]),
            'lesten_master' => fake()->name(),
            'lesten_date' => $startDate,
            'lesten_sex' => fake()->optional()->randomElement(['male', 'female', 'open']),
            'lesten_final' => $endDate,
            'unit_count' => fake()->numberBetween(1, 4),
            'capacity' => fake()->numberBetween(20, 50),
            'registered_count' => fake()->numberBetween(0, 50),
            'lesten_price' => fake()->numberBetween(50000, 500000),
            'class_type' => fake()->randomElement(['theoretical', 'practical', 'mixed']),
            'classroom' => fake()->numerify('###'),
            'class_schedule' => [
                'days' => fake()->randomElements(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'], fake()->numberBetween(1, 3)),
                'time' => fake()->time('H:i'),
            ],
            'status' => fake()->randomElement(['active', 'cancelled', 'completed']),
            'prerequisites' => fake()->optional()->sentence(),
            'lesten_type' => fake()->randomElement(['major', 'general']),
        ];
    }
}
