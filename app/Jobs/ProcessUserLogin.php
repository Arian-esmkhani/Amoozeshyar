<?php

namespace App\Jobs; // تعریف فضای نام برای کارها

use App\Models\UserBase; // استفاده از مدل UserBase
use App\Services\CacheService; // استفاده از سرویس کش
use Illuminate\Bus\Queueable; // استفاده از قابلیت صف
use Illuminate\Contracts\Queue\ShouldQueue; // قرارداد برای صف
use Illuminate\Foundation\Bus\Dispatchable; // قابلیت ارسال کارها
use Illuminate\Queue\InteractsWithQueue; // تعامل با صف
use Illuminate\Queue\SerializesModels; // قابلیت سریال‌سازی
use Illuminate\Support\Facades\Log; // Log برای ثبت رویدادها

class ProcessUserLogin implements ShouldQueue // تعریف کلاس ProcessUserLogin که باید در صف قرار گیرد
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels; // استفاده از قابلیت‌های مختلف

    private int $userId; // تعریف متغیر برای ذخیره شناسه کاربر

    // سازنده کلاس که یک شیء UserBase را به عنوان ورودی می‌گیرد
    public function __construct(UserBase $user)
    {
        $this->userId = $user->id; // ذخیره شناسه کاربر
    }

    // متد handle که برای پردازش ورود کاربر استفاده می‌شود
    public function handle(CacheService $cacheService): void
    {
        try {
            $user = UserBase::find($this->userId); // پیدا کردن کاربر با شناسه
            if (!$user) {
                return; // اگر کاربر پیدا نشد، متد را ترک می‌کند
            }

            // کش کردن داده‌های کاربر
            $cacheService->getUserFromCache($user->id);

            // ثبت رویداد ورود کاربر
            Log::info('User logged in', [
                'user_id' => $user->id, // شناسه کاربر
                'username' => $user->username, // نام کاربری
                'role' => $user->role, // نقش کاربر
            ]);
        } catch (\Exception $e) {
            // ثبت خطا در صورت بروز مشکل
            Log::error('Error processing user login', [
                'user_id' => $this->userId, // شناسه کاربر
                'error' => $e->getMessage(), // پیام خطا
            ]);
        }
    }
}

