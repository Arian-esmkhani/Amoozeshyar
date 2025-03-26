<?php

namespace Database\Factories;

use App\Models\LoginHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoginHistoryFactory extends Factory
{
    protected $model = LoginHistory::class;

    public function definition(): array
    {
        $loginTime = fake()->dateTimeBetween('-1 month', 'now');
        $logoutAt = fake()->optional()->dateTimeBetween($loginTime, 'now');
        $isActive = is_null($logoutAt);

        return [
            'login_time' => $loginTime,
            'logout_at' => $logoutAt,
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'status' => fake()->randomElement(['success', 'failed']),
            'failure_reason' => fake()->optional()->sentence(),
            'is_active' => $isActive,
            'last_login_at' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
