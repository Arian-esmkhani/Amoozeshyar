<?php

namespace Database\Factories;

use App\Models\UserData;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDataFactory extends Factory
{
    protected $model = UserData::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'father_name' => fake()->firstNameMale(),
            'national_code' => fake()->unique()->numerify('##########'),
            'birth_date' => fake()->dateTimeBetween('-30 years', '-18 years'),
            'gender' => fake()->randomElement(['male', 'female']),
            'phone' => fake()->numerify('09##########'),
            'address' => fake()->address(),
            'profile_image' => fake()->imageUrl(640, 480, 'people'),
        ];
    }
}
