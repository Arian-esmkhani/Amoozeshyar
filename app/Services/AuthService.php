<?php

namespace App\Services;

use App\Models\UserBase; // مدل پایه کاربران
use App\Models\LoginHistory; // مدل تاریخچه ورود
use App\Jobs\ProcessUserLogin; // جاب پردازش ورود کاربر
use Illuminate\Support\Facades\Auth; // فاساد احراز هویت
use Illuminate\Support\Facades\Queue; // فاساد صف
use Illuminate\Validation\ValidationException; // خطای اعتبارسنجی

/**
 * سرویس مدیریت احراز هویت
 *
 * این سرویس مسئولیت مدیریت فرآیند ورود و خروج کاربران را بر عهده دارد
 * و شامل قابلیت‌هایی مانند محدودیت تعداد تلاش‌های ورود و ثبت تاریخچه است
 */
class AuthService
{
    /**
     * حداکثر تعداد تلاش‌های مجاز برای ورود
     */
    private const MAX_LOGIN_ATTEMPTS = 7;

    /**
     * سرویس کش برای مدیریت داده‌های موقت
     */
    private CacheService $cacheService;

    /**
     * سازنده کلاس
     *
     * @param CacheService $cacheService سرویس کش
     */
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * پردازش ورود کاربر
     *
     * @param array $credentials اطلاعات ورود شامل نام کاربری و رمز عبور
     * @return array اطلاعات کاربر و توکن دسترسی
     * @throws ValidationException در صورت خطا در ورود
     */
    public function login(array $credentials): array
    {
        // بررسی تعداد تلاش‌های ورود
        $this->checkLoginAttempts($credentials['username']);

        // جستجوی کاربر در دیتابیس
        $user = UserBase::where('username', $credentials['username'])->first();

        // تلاش برای احراز هویت
        if (!Auth::attempt($credentials)) {
            // افزایش تعداد تلاش‌ها
            $this->incrementLoginAttempts($credentials['username']);

            // ثبت تلاش ناموفق در تاریخچه
            if ($user) {
                LoginHistory::create([
                    'user_id' => $user->id,
                    'login_time' => now(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'status' => 'failed',
                    'failure_reason' => 'نام کاربری یا رمز عبور اشتباه است',
                    'is_active' => false
                ]);
            }

            throw ValidationException::withMessages([
                'username' => ['نام کاربری یا رمز عبور اشتباه است.'],
            ]);
        }

        /** @var UserBase $user */
        $user = Auth::user();
        // بازنشانی تعداد تلاش‌های ورود
        $this->resetLoginAttempts($credentials['username']);

        // ثبت ورود موفق در تاریخچه
        $loginHistory = LoginHistory::create([
            'user_id' => $user->id,
            'login_time' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'success',
            'is_active' => true,
            'last_login_at' => now()
        ]);

        // ارسال رویداد ورود به صف پردازش
        Queue::push(new ProcessUserLogin($user));

        return [
            'user' => $user,
            'token' => $user->createToken('auth-token')->plainTextToken,
        ];
    }

    /**
     * پردازش خروج کاربر
     */
    public function logout(): void
    {
        /** @var UserBase|null $user */
        $user = Auth::user();
        if ($user) {
            // ثبت زمان خروج در آخرین رکورد ورود فعال
            LoginHistory::where('user_id', $user->id)
                ->where('is_active', true)
                ->latest()
                ->first()?->update([
                    'logout_at' => now(),
                    'is_active' => false
                ]);

            // حذف توکن‌های دسترسی
            $user->tokens()->delete();
            // پاک کردن کش کاربر
            $this->cacheService->clearUserCache($user->id);
        }
        Auth::logout();
    }

    /**
     * بررسی تعداد تلاش‌های ورود
     *
     * @param string $username نام کاربری
     * @throws ValidationException در صورت بیش از حد مجاز تلاش
     */
    private function checkLoginAttempts(string $username): void
    {
        $attempts = $this->cacheService->getLoginAttempts($username);
        if ($attempts >= self::MAX_LOGIN_ATTEMPTS) {
            throw ValidationException::withMessages([
                'username' => ['حساب کاربری شما موقتاً قفل شده است. لطفاً چند دقیقه دیگر تلاش کنید.'],
            ]);
        }
    }

    /**
     * افزایش تعداد تلاش‌های ورود
     *
     * @param string $username نام کاربری
     */
    private function incrementLoginAttempts(string $username): void
    {
        $this->cacheService->incrementLoginAttempts($username);
    }

    /**
     * بازنشانی تعداد تلاش‌های ورود
     *
     * @param string $username نام کاربری
     */
    private function resetLoginAttempts(string $username): void
    {
        $this->cacheService->resetLoginAttempts($username);
    }

    /**
     * دریافت اطلاعات کاربر از کش
     *
     * @param int $userId شناسه کاربر
     * @return UserBase|null اطلاعات کاربر
     */
    public function getUserFromCache(int $userId): ?UserBase
    {
        return $this->cacheService->getUserFromCache($userId);
    }
}
