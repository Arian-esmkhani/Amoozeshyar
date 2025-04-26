<?php

namespace App\Http\Middleware;

// استفاده از Closure برای ادامه پردازش درخواست‌ها
use Closure;

// استفاده از کلاس Request برای دریافت اطلاعات درخواست کاربر
use Illuminate\Http\Request;

// استفاده از کلاس Response برای مدیریت پاسخ‌های HTTP
use Symfony\Component\HttpFoundation\Response;

// تعریف کلاس VerifyCsrfToken
class VerifyCsrfToken
{
    /**
     * مدیریت یک درخواست ورودی.
     *
     * @param  Request $request اطلاعات مربوط به درخواست ورودی
     * @param  Closure $next تابعی که درخواست را به مرحله بعدی پردازش هدایت می‌کند
     * @return Response پاسخ نهایی به درخواست
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ارسال درخواست به مرحله بعدی پردازش بدون اعتبارسنجی CSRF در این نسخه
        return $next($request);
    }
}
