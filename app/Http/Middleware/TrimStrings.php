<?php

namespace App\Http\Middleware;

// استفاده از Closure برای مدیریت ادامه درخواست‌ها
use Closure;

// استفاده از Request برای مدیریت درخواست HTTP
use Illuminate\Http\Request;

// استفاده از Response برای مدیریت پاسخ‌های HTTP
use Symfony\Component\HttpFoundation\Response;

// تعریف کلاس TrimStrings
class TrimStrings
{
    /**
     * مدیریت یک درخواست ورودی.
     *
     * @param  Request $request درخواست ورودی کاربر
     * @param  Closure $next تابعی که درخواست را به مرحله بعد هدایت می‌کند
     * @return Response پاسخ نهایی به درخواست
     */
    public function handle(Request $request, Closure $next): Response
    {
        // حذف فضاهای اضافی از ورودی ها با فرمت استرینگ
        $trimmed = array_map(fn($value) => is_string($value) ? trim($value) : $value, $request->all());

        // به‌روزرسانی درخواست با مقادیر اصلاح‌شده
        $request->merge($trimmed);


        // ارسال درخواست به مرحله بعدی پردازش
        return $next($request);
    }
}