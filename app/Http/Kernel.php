<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * میدلورهای سراسری برنامه که روی همه درخواست‌ها اجرا می‌شوند
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class, // هاست هایی که اجازه دست رسی دارند
        \App\Http\Middleware\TrustProxies::class, // مدیریت پروکسی های قابل اعتماد برنامه
        \Illuminate\Http\Middleware\HandleCors::class, // مدیریت CORS
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class, // جلوگیری از درخواست‌ها در حالت تعمیر
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // اعتبارسنجی حجم پست
        \App\Http\Middleware\TrimStrings::class, // حذف فضاهای خالی از رشته‌ها
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // تبدیل رشته‌های خالی به null
    ];

    /**
     * گروه‌های میدلور برنامه بر اساس نوع درخواست
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class, // رمزنگاری کوکی‌ها
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, // اضافه کردن کوکی‌های در صف به پاسخ
            \Illuminate\Session\Middleware\StartSession::class, // شروع  و مدریت Session
            \Illuminate\View\Middleware\ShareErrorsFromSession::class, // به اشتراک گذاری خطاها از Session
            \App\Http\Middleware\VerifyCsrfToken::class, // اعتبارسنجی توکن CSRF
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // جایگزینی متغیرهای مسیر
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // مدیریت و امنیت درخواست‌ها بین فرانت‌اند و بک‌اند است
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api', // محدودیت درخواست‌های API
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // جایگزینی متغیرهای مسیر
        ],
    ];

    /**
     * نام‌های مستعار میدلورها برای استفاده راحت‌تر
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class, // احراز هویت کاربر
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, // احراز هویت پایه
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class, // احراز هویت session
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, // تنظیم هدرهای کش
        'can' => \Illuminate\Auth\Middleware\Authorize::class, // بررسی دسترسی‌ها
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // هدایت کاربران وارد شده
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class, // درخواست تأیید رمز عبور
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class, // پردازش درخواست‌های پیش‌بینی
        'signed' => \App\Http\Middleware\ValidateSignature::class, // اعتبارسنجی امضا
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // محدودیت درخواست‌ها
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // اطمینان از تأیید ایمیل
    ];
}
