<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * میدلورهای سراسری برنامه که روی همه درخواست‌ها اجرا می‌شوند
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        // هاست هایی که اجازه دسترسی دارند و فقط درخواست‌های معتبر را پردازش می‌کند

        \App\Http\Middleware\TrustProxies::class,
        // مدیریت پروکسی‌های قابل اعتماد برای پردازش صحیح اطلاعات آی‌پی کاربران

        \Illuminate\Http\Middleware\HandleCors::class,// محدود کردن دسترسی و مدیریت روش‌های HTTP و ...
        // CORS سیاست های مدیریت

        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        // جلوگیری از پردازش درخواست‌ها در حالت تعمیر و نگهداری

        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // اعتبارسنجی حجم داده‌های ارسال شده از طریق POST برای جلوگیری از حجم بیش از حد مجاز

        \App\Http\Middleware\TrimStrings::class,
        // حذف فضاهای خالی اضافه در ابتدا و انتهای رشته‌های ورودی برای استانداردسازی داده‌ها

        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        // تبدیل رشته‌های خالی به مقدار null برای مدیریت بهتر داده‌ها در پایگاه داده
    ];

    /**
     * گروه‌های میدلور برنامه بر اساس نوع درخواست
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, // اضافه کردن کوکی‌های در صف به پاسخ
            \Illuminate\Session\Middleware\StartSession::class, // شروع  و مدریت Session ورای ذخیره داده‌های موقت کاربر مثل اطلاعات احراز هویت یا متغیرهای سراسری مفید است.
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
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class, // احراز هویت session - اگر کاربر از دستگاه دیگری وارد شده باشد، نشست قبلی را غیرفعال
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, // تنظیم هدرهای کش
        'can' => \Illuminate\Auth\Middleware\Authorize::class, // بررسی دسترسی‌ها
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // هدایت کاربران وارد شده
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class, // پردازش درخواست‌های پیش‌بینی - به فرانت اند اجازه میدهد درخاست هاروو برسی کند بدون اینکه در پایگاه داده ذخیره شوند
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // محدودیت درخواست‌ها
    ];
}
