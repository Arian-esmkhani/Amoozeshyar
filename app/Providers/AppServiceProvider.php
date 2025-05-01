<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;//سرویس ServiceProvider
use Livewire\LivewireServiceProvider;//سرویس Livewire

class AppServiceProvider extends ServiceProvider
{
    /**
     * ثبت هر سرویس برنامه.
     */
    public function register(): void
    {
        // اگر حالت اشکال‌زدایی فعال باشد، سرویس Debugbar را ثبت کن
        if (config('app.debug')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        // ثبت سرویس Livewire
        $this->app->register(LivewireServiceProvider::class);
    }

    /**
     * راه‌اندازی هر سرویس برنامه.
     */
    public function boot(): void
    {
        //
    }
}
