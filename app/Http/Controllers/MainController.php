<?php

namespace App\Http\Controllers; // تعریف فضای نام برای کنترلرها

use App\Models\UserData; // استفاده از مدل UserData
use App\Services\CacheService; // استفاده از سرویس کش
use Illuminate\Support\Facades\Auth; // Auth برای مدیریت احراز هویت

class MainController extends Controller // تعریف کلاس MainController که از Controller ارث می‌برد
{
    protected $cacheService; // تعریف یک متغیر برای ذخیره سرویس کش

    // سازنده کلاس که سرویس کش را به عنوان وابستگی دریافت می‌کند
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService; // ذخیره سرویس کش در متغیر
    }

    // متد index که برای نمایش صفحه اصلی استفاده می‌شود
    public function index()
    {
        $user = Auth::user(); // دریافت کاربر فعلی
        $userData = $this->cacheService->remember( // استفاده از کش برای ذخیره داده‌های کاربر
            "user_data_{$user->id}", // کلید کش
            3600, // زمان انقضای کش به ثانیه
            fn() => UserData::where('user_id', $user->id)->first() // تابعی که داده‌های کاربر را از پایگاه داده می‌گیرد
        );

        // بازگشت به نمای amoozeshyar با داده‌های کاربر و نقش کاربر
        return view('amoozeshyar', [
            'userData' => $userData, // داده‌های کاربر
            'userRole' => $user->role // نقش کاربر
        ]);
    }
}

