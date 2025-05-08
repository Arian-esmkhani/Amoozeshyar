<?php

namespace App\Services;

use App\Models\UserBase; // مدل پایه کاربران
use App\Models\LoginHistory; // مدل تاریخچه ورود
use App\Jobs\ProcessUserLogin; // جاب پردازش ورود کاربر
use Illuminate\Support\Facades\Auth; //  احراز هویت
use Illuminate\Support\Facades\Queue; //  صف
use Illuminate\Validation\ValidationException; // خطای اعتبارسنجی

/**
 * سرویس مدیریت احراز هویت
 * این سرویس مسئولیت مدیریت فرآیند ورود و خروج کاربران را بر عهده دارد
 */
class AuthService
{
    private CacheService $cacheService;

    // سازنده کلاس
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * پردازش ورود کاربر
     *
     * @param array $credentials اطلاعات ورود شامل نام کاربری و رمز عبور
     * @throws ValidationException در صورت خطا در ورود
     */
    public function login(array $credentials): array
    {
        // جستجوی کاربر در دیتابیس
        $user = UserBase::where('username', $credentials['username'])->first();

        // تلاش برای احراز هویت
        if (!Auth::attempt($credentials)) {
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
