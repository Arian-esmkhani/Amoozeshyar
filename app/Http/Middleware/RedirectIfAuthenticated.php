<?php

namespace App\Http\Middleware;

// استفاده از Closure برای ادامه فرآیند درخواست‌ها
use Closure;

// استفاده از Request برای مدیریت درخواست‌های HTTP
use Illuminate\Http\Request;

// استفاده از Auth برای بررسی وضعیت احراز هویت
use Illuminate\Support\Facades\Auth;

// استفاده از Response برای مدیریت پاسخ‌های HTTP
use Symfony\Component\HttpFoundation\Response;

// تعریف کلاس RedirectIfAuthenticated
class RedirectIfAuthenticated
{
    /**
     * پردازش یک درخواست ورودی.
     *
     * @param Request $request درخواست ورودی کاربر
     * @param Closure $next تابعی که درخواست را به مرحله بعد هدایت می‌کند
     * @param string ...$guards لیستی از گاردهای احراز هویت
     * @return Response پاسخ به کاربر
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // اگر گاردها خالی باشند، مقدار پیش‌فرض null قرار می‌گیرد
        $guards = empty($guards) ? [null] : $guards;

        // بررسی هر گارد برای وضعیت احراز هویت کاربر
        foreach ($guards as $guard) {
            // اگر کاربر وارد شده باشد (احراز هویت شده باشد)
            if (Auth::guard($guard)->check()) {
                // هدایت کاربر به داشبورد
                return redirect('/dashboard');
            }
        }

        // اگر کاربر احراز هویت نشده باشد، درخواست ادامه می‌یابد
        return $next($request);
    }
}
