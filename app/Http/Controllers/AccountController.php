<?php

namespace App\Http\Controllers;

// مدل‌های مربوط به دیتابیس
use App\Models\UserAccount;
use App\Models\UserData;
// سرویس کش (Cache) برای ذخیره موقت داده‌ها
use App\Services\CacheService;
// کتابخانه احراز هویت لاراول
use Illuminate\Support\Facades\Auth;

// تعریف کنترلری به نام AccountController
class AccountController extends Controller
{
    // تعریف متغیری برای نگه‌داری سرویس کش
    protected $cacheService;

    // سازنده (Constructor) کنترلر برای مقداردهی اولیه سرویس کش
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    // متدی برای نمایش اطلاعات حساب کاربر
    public function accountView()
    {
        // دریافت اطلاعات کاربر فعلی که لاگین کرده است
        $user = Auth::user();

        // ذخیره یا بازیابی اطلاعات از کش
        $data = $this->cacheService->remember(
            'user_account_' . $user->id, // کلید یکتای کش بر اساس آی‌دی کاربر
            3600, // مدت زمان اعتبار کش (به ثانیه)
            function () use ($user) {
                // دریافت اطلاعات کاربر از جدول UserData
                $userData = UserData::where('user_id', $user->id)->first();

                // دریافت اطلاعات حساب مالی کاربر از جدول UserAccount
                $userAccount = UserAccount::where('user_id', $user->id)->select('balance', 'debt', 'credit', 'payment_status')->first();

                // بازگشت داده‌های ترکیبی شامل اطلاعات شخصی و حساب کاربر
                return [
                    'userData' => $userData,
                    'userAccount' => $userAccount
                ];
            }
        );

        // ارسال داده‌ها به ویوی (View) حساب کاربری
        return view('account', compact('data'));
    }
}