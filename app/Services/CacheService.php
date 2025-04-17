<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;//فرا خوانی ردیس از لاراول

class CacheService
{
    // زمان پیش‌فرض برای ذخیره‌سازی داده‌ها: ۱ ساعت
    private const DEFAULT_TTL = 3600;

    // زمان ذخیره‌سازی برای تلاش‌های ورود: 4 دقیقه
    private const LOGIN_ATTEMPTS_TTL = 240;

    // زمان ذخیره‌سازی برای اطلاعات کاربر: 2 ساعت
    private const USER_CACHE_TTL = 7200;

    // دریافت مقدار از کش
    public function get(string $key, $default = null)
    {
        $value = Redis::get($key); // دریافت مقدار با کلید
        if (!$value) {
            return $default; // بازگشت مقدار پیش‌فرض اگر کلید وجود نداشته باشد
        }

        try {
            return unserialize($value) ?: $default; // تلاش برای دسریالایز کردن مقدار
        } catch (\Throwable $e) {
            return $default; // بازگشت مقدار پیش‌فرض اگر دسریالایز با شکست مواجه شود
        }
    }

    // ذخیره مقدار در کش با زمان مشخص
    public function put(string $key, $value, int $ttl = self::DEFAULT_TTL): bool
    {
        return Redis::setex($key, $ttl, serialize($value)) === 'OK'; // سریالایز کردن مقدار و ذخیره با زمان مشخص
    }

    // حذف مقدار از کش با کلید
    public function forget(string $key): bool
    {
        return Redis::del($key) > 0; // حذف کلید و بررسی موفقیت‌آمیز بودن
    }

    // دریافت مقدار کش شده یا ذخیره آن اگر وجود نداشته باشد
    public function remember(string $key, int $ttl, callable $callback)
    {
        if (Redis::exists($key)) { // بررسی وجود کلید
            $value = Redis::get($key); // دریافت مقدار
            try {
                return unserialize($value) ?: $callback(); // تلاش برای دسریالایز کردن مقدار
            } catch (\Throwable $e) {
                // اگر دسریالایز با مشکل مواجه شد، مقدار جدید را ذخیره می‌کنیم
                $value = $callback();
                $this->put($key, $value, $ttl);
                return $value;
            }
        }

        // اگر کلید وجود نداشته باشد، مقدار را محاسبه و ذخیره می‌کنیم
        $value = $callback();
        $this->put($key, $value, $ttl);
        return $value;
    }

    // افزایش مقدار در کش با مقدار مشخص
    public function increment(string $key, int $value = 1): int
    {
        return (int) Redis::incrby($key, $value); // افزایش مقدار با مقدار مشخص
    }

    // کاهش مقدار در کش با مقدار مشخص
    public function decrement(string $key, int $value = 1): int
    {
        return (int) Redis::decrby($key, $value); // کاهش مقدار با مقدار مشخص
    }

    // دریافت تعداد تلاش‌های ورود برای یک کاربر
    public function getLoginAttempts(string $username): int
    {
        return (int) $this->get("login_attempts.{$username}", 0); // مقدار پیش‌فرض ۰ اگر کلید وجود نداشته باشد
    }

    // افزایش تعداد تلاش‌های ورود برای یک کاربر
    public function incrementLoginAttempts(string $username): int
    {
        $key = "login_attempts.{$username}";
        $attempts = $this->increment($key); // افزایش شمارنده
        Redis::expire($key, self::LOGIN_ATTEMPTS_TTL); // تنظیم زمان انقضا برای تلاش‌های ورود
        return $attempts;
    }

    // بازنشانی شمارنده تلاش‌های ورود برای یک کاربر
    public function resetLoginAttempts(string $username): bool
    {
        return $this->forget("login_attempts.{$username}"); // حذف کلید تلاش‌های ورود
    }

    // دریافت اطلاعات کاربر از کش یا پایگاه داده اگر کش نشده باشد
    public function getUserFromCache(int $userId)
    {
        return $this->remember(
            "user.{$userId}",
            self::USER_CACHE_TTL,
            fn() => \App\Models\UserBase::find($userId) // دریافت کاربر از پایگاه داده اگر کش نشده باشد
        );
    }

    // پاک کردن کش یک کاربر خاص
    public function clearUserCache(int $userId): bool
    {
        return $this->forget("user.{$userId}"); // حذف کلید کش کاربر
    }

    // پاک کردن تمام کش‌های مربوط به کاربران
    public function clearAllUserCache(): void
    {
        $keys = Redis::keys('amoozeshyar_user.*'); // پیدا کردن تمام کلیدهای مطابق الگو
        if (!empty($keys)) {
            Redis::del(...$keys); // حذف تمام کلیدهای مطابق
        }
    }

    // دریافت آمار کش
    public function getCacheStats(): array
    {
        $info = Redis::info(); // دریافت اطلاعات سرور Redis
        return [
            'memory_usage' => $info['used_memory_human'] ?? '0B', // استفاده از حافظه
            'total_keys' => Redis::dbsize(), // تعداد کلیدهای موجود در پایگاه داده
            'uptime' => $info['uptime_in_seconds'] ?? 0, // زمان فعالیت سرور به ثانیه
        ];
    }

    // پاک کردن تمام داده‌های کش شده
    public function flush(): bool
    {
        return Redis::flushdb() === 'OK'; // حذف تمام کلیدها در پایگاه داده فعلی
    }
}
