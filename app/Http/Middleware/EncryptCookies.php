<?php

namespace App\Http\Middleware;

// استفاده از کلاس Closure برای کنترل ادامه فرآیند درخواست‌ها
use Closure;

// استفاده از کلاس Request برای مدیریت درخواست HTTP
use Illuminate\Http\Request;

// استفاده از کلاس Response برای پاسخ دادن به درخواست
use Symfony\Component\HttpFoundation\Response;

// تعریف کلاس EncryptCookies
class EncryptCookies
{
    /**
     * مدیریت یک درخواست ورودی.
     *
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ارسال درخواست به مرحله بعدی پردازش
        return $next($request);
    }
}
