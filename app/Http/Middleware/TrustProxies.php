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
    //لیست پروکسی‌های مورد اعتماد.
    protected $proxies = '*';

    // تنظیم هدرهایی که برای تشخیص آی‌پی اصلی کاربران استفاده می‌شوند.
    protected $headers = [
        'X-Forwarded-For',   // آی‌پی اصلی کاربر و مسیر پروکسی‌های عبوری را مشخص می‌کند.
        'X-Forwarded-Host',  // نام دامنه‌ای که درخواست از آن ارسال شده را مشخص می‌کند.
        'X-Forwarded-Port',  // شماره پورت درخواست اصلی (مثلاً 80 برای HTTP یا 443 برای HTTPS).
        'X-Forwarded-Proto', // نشان می‌دهد که درخواست اولیه با HTTP یا HTTPS ارسال شده است.
        'X-Forwarded-Server',// نام سرور پروکسی که درخواست را پردازش کرده است.
        'X-Forwarded-Ssl',   // مشخص می‌کند که درخواست اولیه از طریق SSL/TLS ارسال شده یا نه.
    ];

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
        //زیرا این میدلور فقط آی‌پی کاربران را از طریق تنظیمات TrustProxies مدیریت می‌کند
        return $next($request);
    }
}
