<?php

namespace Database\Factories;

use App\Models\UserBase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserBaseFactory extends Factory
{
    protected $model = UserBase::class;

    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'password' => bcrypt('password'),
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->randomElement(['admin', 'teacher', 'student']),
        ];
    }

    public function admin(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    public function teacher(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'teacher',
            ];
        });
    }

    public function student(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'student',
            ];
        });
    }
}
