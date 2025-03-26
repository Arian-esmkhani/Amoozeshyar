<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheService
{
    private const DEFAULT_TTL = 3600; // 1 hour
    private const LOGIN_ATTEMPTS_TTL = 300; // 5 minutes
    private const USER_CACHE_TTL = 3600; // 1 hour

    public function get(string $key, $default = null)
    {
        return Cache::get($key, $default);
    }

    public function put(string $key, $value, int $ttl = self::DEFAULT_TTL): bool
    {
        return Cache::put($key, $value, $ttl);
    }

    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    public function remember(string $key, int $ttl, callable $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }

    public function increment(string $key, int $value = 1): int
    {
        return Cache::increment($key, $value);
    }

    public function decrement(string $key, int $value = 1): int
    {
        return Cache::decrement($key, $value);
    }

    public function getLoginAttempts(string $username): int
    {
        return $this->get("login_attempts.{$username}", 0);
    }

    public function incrementLoginAttempts(string $username): int
    {
        return $this->increment("login_attempts.{$username}");
    }

    public function resetLoginAttempts(string $username): bool
    {
        return $this->forget("login_attempts.{$username}");
    }

    public function getUserFromCache(int $userId)
    {
        return $this->remember(
            "user.{$userId}",
            self::USER_CACHE_TTL,
            fn() => \App\Models\UserBase::find($userId)
        );
    }

    public function clearUserCache(int $userId): bool
    {
        return $this->forget("user.{$userId}");
    }

    public function clearAllUserCache(): void
    {
        $keys = Redis::keys('amoozeshyar_user.*');
        foreach ($keys as $key) {
            Redis::del($key);
        }
    }

    public function getCacheStats(): array
    {
        return [
            'memory_usage' => Redis::info()['used_memory_human'],
            'total_keys' => Redis::dbsize(),
            'uptime' => Redis::info()['uptime_in_seconds'],
        ];
    }
}
