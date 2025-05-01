<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;//گیت
use Laravel\Telescope\IncomingEntry;//یکی از داده‌های ورودی
use Laravel\Telescope\Telescope;//سرویس Telescope
use Laravel\Telescope\TelescopeApplicationServiceProvider;//سرویس TelescopeApplicationServiceProvider

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * ثبت هر سرویس برنامه.
     */
    public function register(): void
    {
        Telescope::night(); // فعال‌سازی حالت شب

        $this->hideSensitiveRequestDetails(); // پنهان کردن جزئیات حساس درخواست

        $isLocal = $this->app->environment('local'); // بررسی محیط محلی

        Telescope::filter(function (IncomingEntry $entry) use ($isLocal) {
            return $isLocal || // اگر در محیط محلی هستیم
                   $entry->isReportableException() || // استثنای قابل گزارش
                   $entry->isFailedRequest() || // درخواست ناموفق
                   $entry->isFailedJob() || // کار ناموفق
                   $entry->isScheduledTask() || // کار زمان‌بندی شده
                   $entry->hasMonitoredTag(); // برچسب تحت نظارت
        });
    }

    /**
     * جلوگیری از ثبت جزئیات حساس درخواست‌ها توسط Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment('local')) {
            return; // اگر در محیط محلی هستیم، ادامه نده
        }

        Telescope::hideRequestParameters(['_token']); // پنهان کردن پارامترهای درخواست

        Telescope::hideRequestHeaders([
            'cookie', // پنهان کردن کوکی‌ها
            'x-csrf-token', // پنهان کردن توکن CSRF
            'x-xsrf-token', // پنهان کردن توکن XSRF
        ]);
    }

    /**
     * ثبت دروازه Telescope.
     *
     * این دروازه تعیین می‌کند که چه کسی می‌تواند به Telescope در محیط‌های غیرمحلی دسترسی داشته باشد.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [
                // لیست کاربران مجاز
            ]);
        });
    }
}
