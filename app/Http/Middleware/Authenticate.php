<?php

namespace App\Http\Middleware;

// استفاده از میدلور پایه‌ای Authenticate
use Illuminate\Auth\Middleware\Authenticate as Middleware;

// استفاده از کلاس Request برای مدیریت درخواست‌ها
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * مسیری که کاربر به آن هدایت می‌شود اگر احراز هویت نشده باشد
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
