<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class CacheService
{
    private const DEFAULT_TTL = 3600; // 1 hour
    private const LOGIN_ATTEMPTS_TTL = 300; // 5 minutes
    private const USER_CACHE_TTL = 3600; // 1 hour

    public function get(string $key, $default = null)
    {
        $value = Redis::get($key);
        if (!$value) {
            return $default;
        }

        try {
            return unserialize($value) ?: $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    public function put(string $key, $value, int $ttl = self::DEFAULT_TTL): bool
    {
        return Redis::setex($key, $ttl, serialize($value)) === 'OK';
    }

    public function forget(string $key): bool
    {
        return Redis::del($key) > 0;
    }

    public function remember(string $key, int $ttl, callable $callback)
    {
        if (Redis::exists($key)) {
            $value = Redis::get($key);
            try {
                return unserialize($value) ?: $callback();
            } catch (\Throwable $e) {
                // اگر دسریالایز با مشکل مواجه شد، مقدار جدید را ذخیره می‌کنیم
                $value = $callback();
                $this->put($key, $value, $ttl);
                return $value;
            }
        }

        $value = $callback();
        $this->put($key, $value, $ttl);
        return $value;
    }

    public function increment(string $key, int $value = 1): int
    {
        return (int) Redis::incrby($key, $value);
    }

    public function decrement(string $key, int $value = 1): int
    {
        return (int) Redis::decrby($key, $value);
    }

    public function getLoginAttempts(string $username): int
    {
        return (int) $this->get("login_attempts.{$username}", 0);
    }

    public function incrementLoginAttempts(string $username): int
    {
        $key = "login_attempts.{$username}";
        $attempts = $this->increment($key);
        Redis::expire($key, self::LOGIN_ATTEMPTS_TTL);
        return $attempts;
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
        if (!empty($keys)) {
            Redis::del(...$keys);
        }
    }

    public function getCacheStats(): array
    {
        $info = Redis::info();
        return [
            'memory_usage' => $info['used_memory_human'] ?? '0B',
            'total_keys' => Redis::dbsize(),
            'uptime' => $info['uptime_in_seconds'] ?? 0,
        ];
    }

    public function flush(): bool
    {
        return Redis::flushdb() === 'OK';
    }
}
