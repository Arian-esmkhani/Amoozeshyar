<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate; // بررسی احراز هویت کاربر قبل از دسترسی به پنل
use Filament\Http\Middleware\AuthenticateSession; // اعتبارسنجی و مدیریت نشست‌های کاربر در پنل
use Filament\Http\Middleware\DisableBladeIconComponents; // غیرفعال کردن کامپوننت‌های آیکون‌های Blade در Filament
use Filament\Http\Middleware\DispatchServingFilamentEvent; // ارسال رویداد Serving Filament هنگام اجرای پنل
use Filament\Pages; // مدیریت صفحات داخل پنل Filament
use Filament\Panel; // نمایش و کنترل یک پنل مدیریتی در Filament
use Filament\PanelProvider; // کلاس ارائه‌دهنده‌ی پنل‌های مدیریتی برای Filament
use Filament\Support\Colors\Color; // استفاده از رنگ‌ها در رابط کاربری Filament
use Filament\Widgets; // مدیریت و نمایش ویجت‌ها در پنل Filament
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse; // اضافه کردن کوکی‌ها به پاسخ درخواست HTTP
use Illuminate\Cookie\Middleware\EncryptCookies; // رمزگذاری کوکی‌ها برای امنیت بیشتر
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken; // بررسی CSRF برای جلوگیری از حملات درخواست جعلی
use Illuminate\Routing\Middleware\SubstituteBindings; // جایگزینی پارامترهای مسیر با مقدار واقعی
use Illuminate\Session\Middleware\StartSession; // مدیریت و شروع نشست‌های کاربر
use Illuminate\View\Middleware\ShareErrorsFromSession; // اشتراک‌گذاری خطاهای نشست برای نمایش در قالب‌های Blade

class AdminPanelProvider extends PanelProvider
{
    // تابعی برای تنظیمات پنل مدیریت
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default() // تنظیمات پیش‌فرض پنل
            ->id('admin') // شناسه پنل
            ->path('admin') // مسیر پنل
            ->login() // فعال‌سازی ورود به پنل
            ->colors([ // تنظیم رنگ‌ها
                'primary' => Color::Amber, // رنگ اصلی
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources') // کشف منابع
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages') // کشف صفحات
            ->pages([ // صفحات موجود در پنل
                Pages\Dashboard::class, // صفحه داشبورد
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets') // کشف ویجت‌ها
            ->widgets([ // ویجت‌های موجود در پنل
                Widgets\AccountWidget::class, // ویجت حساب کاربری
                Widgets\FilamentInfoWidget::class, // ویجت اطلاعات فیلامنت
            ])
            ->middleware([ // میدل‌ورهای مورد استفاده
                EncryptCookies::class, // رمزگذاری کوکی‌ها
                AddQueuedCookiesToResponse::class, // افزودن کوکی‌های صف شده به پاسخ
                StartSession::class, // شروع جلسه
                AuthenticateSession::class, // احراز هویت جلسه
                ShareErrorsFromSession::class, // به اشتراک‌گذاری خطاها از جلسه
                VerifyCsrfToken::class, // تأیید توکن CSRF
                SubstituteBindings::class, // جایگزینی بایندینگ‌ها
                DisableBladeIconComponents::class, // غیرفعال‌سازی کامپوننت‌های آیکون بلید
                DispatchServingFilamentEvent::class, // ارسال رویدادهای فیلامنت
            ])
            ->authMiddleware([ // میدل‌ور احراز هویت
                Authenticate::class, // احراز هویت
            ]);
    }
}

