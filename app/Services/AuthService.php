<?php

namespace App\Services;

use App\Models\UserBase;
use App\Models\LoginHistory;
use App\Jobs\ProcessUserLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private const MAX_LOGIN_ATTEMPTS = 5;
    private CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function login(array $credentials): array
    {
        $this->checkLoginAttempts($credentials['username']);

        if (!Auth::attempt($credentials)) {
            $this->incrementLoginAttempts($credentials['username']);

            // ثبت تلاش ناموفق در تاریخچه
            LoginHistory::create([
                'user_id' => UserBase::where('username', $credentials['username'])->first()?->id,
                'login_time' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'status' => 'failed',
                'failure_reason' => 'نام کاربری یا رمز عبور اشتباه است',
                'is_active' => false
            ]);

            throw ValidationException::withMessages([
                'username' => ['نام کاربری یا رمز عبور اشتباه است.'],
            ]);
        }

        /** @var UserBase $user */
        $user = Auth::user();
        $this->resetLoginAttempts($credentials['username']);

        // ثبت لاگین موفق در تاریخچه
        LoginHistory::create([
            'user_id' => $user->id,
            'login_time' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'success',
            'is_active' => true,
            'last_login_at' => now()
        ]);

        // Queue user login event
        Queue::push(new ProcessUserLogin($user, $this->cacheService));

        return [
            'user' => $user,
            'token' => $user->createToken('auth-token')->plainTextToken,
        ];
    }

    public function logout(): void
    {
        /** @var UserBase|null $user */
        $user = Auth::user();
        if ($user) {
            // ثبت لاگ‌اوت در آخرین رکورد لاگین فعال
            LoginHistory::where('user_id', $user->id)
                ->where('is_active', true)
                ->latest()
                ->first()?->update([
                    'logout_at' => now(),
                    'is_active' => false
                ]);

            $user->tokens()->delete();
            $this->cacheService->clearUserCache($user->id);
        }
        Auth::logout();
    }

    private function checkLoginAttempts(string $username): void
    {
        $attempts = $this->cacheService->getLoginAttempts($username);
        if ($attempts >= self::MAX_LOGIN_ATTEMPTS) {
            throw ValidationException::withMessages([
                'username' => ['حساب کاربری شما موقتاً قفل شده است. لطفاً چند دقیقه دیگر تلاش کنید.'],
            ]);
        }
    }

    private function incrementLoginAttempts(string $username): void
    {
        $this->cacheService->incrementLoginAttempts($username);
    }

    private function resetLoginAttempts(string $username): void
    {
        $this->cacheService->resetLoginAttempts($username);
    }

    public function getUserFromCache(int $userId): ?UserBase
    {
        return $this->cacheService->getUserFromCache($userId);
    }
}
