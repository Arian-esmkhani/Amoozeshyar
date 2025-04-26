<?php

namespace App\Http\Middleware;

// استفاده از Closure برای مدیریت انتقال درخواست به مرحله بعدی
use Closure;

// استفاده از کلاس Request برای دریافت اطلاعات درخواست
use Illuminate\Http\Request;

// استفاده از Response برای مدیریت پاسخ‌های HTTP
use Symfony\Component\HttpFoundation\Response;

// تعریف کلاس ValidateSignature
class ValidateSignature
{
    /**
     * مدیریت درخواست ورودی.
     *
     * @param  Request $request اطلاعات مربوط به درخواست ورودی
     * @param  Closure $next تابعی که درخواست را به مرحله بعدی پردازش هدایت می‌کند
     * @return Response پاسخ نهایی به درخواست
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ارسال درخواست به مرحله بعدی پردازش بدون هیچ تغییری
        return $next($request);
    }
}
