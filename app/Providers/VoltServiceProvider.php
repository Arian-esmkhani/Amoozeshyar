<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;//سرویس ServiceProvider
use Livewire\Volt\Volt;//سرویس Volt

class VoltServiceProvider extends ServiceProvider
{
    /**
     * ثبت سرویس‌ها.
     */
    public function register(): void
    {
        // اینجا می‌توانید سرویس‌های خود را ثبت کنید
    }

    /**
     * راه‌اندازی سرویس‌ها.
     */
    public function boot(): void
    {
        // بارگذاری مسیرهای نمای Volt
        Volt::mount([
            config('livewire.view_path', resource_path('views/livewire')), // مسیر نمای Livewire
            resource_path('views/pages'), // مسیر نمای صفحات
        ]);
    }
}
