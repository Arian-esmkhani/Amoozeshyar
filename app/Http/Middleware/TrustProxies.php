<?php

namespace App\Http\Middleware;

// استفاده از Closure برای انتقال درخواست به مرحله بعدی
use Closure;

// استفاده از Request برای مدیریت اطلاعات درخواست HTTP
use Illuminate\Http\Request;

// استفاده از Response برای مدیریت اطلاعات پاسخ HTTP
use Symfony\Component\HttpFoundation\Response;

// تعریف کلاس TrustProxies
class TrustProxies
{
    /**
     * مدیریت درخواست ورودی.
     *
     * @param  Request $request درخواست کاربر به سرور
     * @param  Closure $next تابعی که درخواست را به مرحله بعد انتقال می‌دهد
     * @return Response پاسخ نهایی به درخواست
     */
    public function handle(Request $request, Closure $next): Response
    {
        // انتقال درخواست به مرحله بعدی بدون هیچ تغییری
        return $next($request);
    }
}
