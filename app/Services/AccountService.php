<?php

namespace App\Services;

use App\Models\UserAccount;
use Illuminate\Support\Facades\Auth; //استفاده از اوچیکیشن

//با این کلاس سرویس کار با بخش مالی کار بر را میسازیم
class AccountService
{
    //این متغیر برای ذخیره حساب کاربر است
    protected $userAccount;

    //این کانستراکتور برای ذخیره حساب کاربر است
    public function __construct()
    {
        $this->userAccount = UserAccount::where('user_id', Auth::user()->id)->first();
    }

    //این متد برای وقتی است که به هزینه های کاربر اضافه می شود
    public function ubdateDebt($money)
    {
        // ابتدا بدهی را به‌روز می‌کنیم
        $newDebt = $money;
        $currentCredit = $this->userAccount->credit;

        // محاسبه balance جدید
        $newBalance = $currentCredit - $newDebt;

        // به‌روزرسانی همه مقادیر با هم
        $this->userAccount->update([
            'debt' => $newDebt,
            'balance' => $newBalance
        ]);

        // اگر بدهی منفی شد (یعنی مازاد اعتبار داریم)
        if ($newDebt < 0) {
            $adjustedCredit = $currentCredit - $newDebt; // اضافه کردن مقدار منفی بدهی به اعتبار
            $this->userAccount->update([
                'credit' => $adjustedCredit,
                'debt' => 0,
                'balance' => $adjustedCredit // در این حالت balance برابر با credit است چون debt صفر است
            ]);
        }
    }

    // این متد برای زمانی است که اعتباری به حساب کاربر اضافه می‌شود (مثلاً پرداخت شهریه یا حذف درس)
    public function updateCredit($money)
    {
        $currentCredit = $this->userAccount->credit;
        $currentDebt = $this->userAccount->debt;

        // محاسبه بدهی جدید: بدهی فعلی منهای پولی که آمده
        $newDebt = $currentDebt - $money;
        $newCredit = $currentCredit; // اعتبار فعلا تغییری نکرده

        // اگر بدهی منفی شد، یعنی پول بیشتر از بدهی بوده
        if ($newDebt < 0) {
            // مقدار اضافی پول (قدر مطلق بدهی منفی) به اعتبار اضافه می‌شود
            $newCredit = $currentCredit + abs($newDebt);
            // بدهی صفر می‌شود
            $newDebt = 0;
        }

        // محاسبه بالانس نهایی بر اساس اعتبار و بدهی جدید
        $newBalance = $newCredit - $newDebt;

        // به‌روزرسانی رکورد
        $this->userAccount->update([
            'credit' => $newCredit,
            'debt' => $newDebt,
            'balance' => $newBalance
        ]);
    }

    // این متد برای زمانی است که هزینه ای به کاربر تحمیل می شود (مثلاً برداشتن درس)
    public function userAdd($money)
    {
        $currentCredit = $this->userAccount->credit;
        $currentDebt = $this->userAccount->debt;

        // محاسبه اعتبار جدید: اعتبار فعلی منهای هزینه
        $newCredit = $currentCredit - $money;
        $newDebt = $currentDebt; // بدهی فعلا تغییری نکرده

        // اگر اعتبار منفی شد، یعنی هزینه بیشتر از اعتبار بوده
        if ($newCredit < 0) {
            // مقدار کمبود اعتبار (قدر مطلق اعتبار منفی) به بدهی اضافه می‌شود
            $newDebt = $currentDebt + abs($newCredit);
            // اعتبار صفر می‌شود
            $newCredit = 0;
        }

        // محاسبه بالانس نهایی بر اساس اعتبار و بدهی جدید
        $newBalance = $newCredit - $newDebt;

        // به‌روزرسانی رکورد
        $this->userAccount->update([
            'credit' => $newCredit,
            'debt' => $newDebt,
            'balance' => $newBalance
        ]);
    }
}
