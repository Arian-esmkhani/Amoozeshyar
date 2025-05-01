<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default() // تنظیمات پیش‌فرض پنل
            ->id('admin') // مشخص کردن شناسه پنل
            ->path('admin') // مسیر دسترسی به پنل
            ->login() // تنظیم قابلیت ورود به سیستم در پنل فیلمنت
            ->colors([
                    'primary' => Color::Amber, // تنظیم رنگ اصلی پنل
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources') // کشف و بارگذاری منابع
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages') // کشف و بارگذاری صفحات
            ->pages([
                Pages\Dashboard::class, // صفحه داشبورد
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets') // کشف و بارگذاری ویجت‌ها
            ->widgets([
                Widgets\AccountWidget::class, // ویجت اطلاعات حساب
                Widgets\FilamentInfoWidget::class, // ویجت اطلاعات فیلمنت
            ])
            ->middleware([
                EncryptCookies::class, // رمزگذاری کوکی‌ها
                AddQueuedCookiesToResponse::class, // اضافه کردن کوکی‌ها به پاسخ
                StartSession::class, // شروع نشست کاربری
                AuthenticateSession::class, // احراز هویت نشست کاربری
                ShareErrorsFromSession::class, // اشتراک گذاری خطاهای نشست
                VerifyCsrfToken::class, // بررسی توکن CSRF
                SubstituteBindings::class, // جایگزینی Bindings
                DisableBladeIconComponents::class, // غیرفعال کردن آیکون‌های Blade
                DispatchServingFilamentEvent::class, // ارسال رویداد فیلمنت
            ])
            ->authMiddleware([
                Authenticate::class, // احراز هویت کاربران
            ]);
    }
}
