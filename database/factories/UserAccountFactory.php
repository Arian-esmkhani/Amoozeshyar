<?php

namespace Database\Factories;

use App\Models\UserAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAccountFactory extends Factory
{
    protected $model = UserAccount::class;

    public function definition(): array
    {
        return [
            'balance' => fake()->numberBetween(0, 1000000),
            'debt' => fake()->numberBetween(0, 500000),
            'credit' => fake()->numberBetween(0, 2000000),
            'payment_status' => fake()->randomElement(['active', 'suspended', 'blocked']),
            'bank_account_number' => fake()->numerify('################'),
            'transaction_reference' => fake()->unique()->numerify('################'),
        ];
    }
}
