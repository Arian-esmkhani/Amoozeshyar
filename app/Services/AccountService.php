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

    public function ubdatCredit($money)
    {
        if ($this->userAccount->debt >= $money) {
            $this->userAccount->update([
                'debt' => $this->userAccount->debt - $money,
                'balance' => $this->userAccount->credit - $this->userAccount->debt
            ]);
        } else {
            $this->userAccount->update([
                'credit' => $this->userAccount->credit - ($this->userAccount->debt - $money),
                'balance' => $this->userAccount->credit - $this->userAccount->debt
            ]);
        }
        if ($this->userAccount->debt < 0) {
            $this->userAccount->update([
                'credit' => $this->userAccount->credit - $this->userAccount->debt,
                'debt' => 0,
                'balance' => $this->userAccount->credit - $this->userAccount->debt
            ]);
        }
    }

    public function userAdd($money)
    {
        if ($this->userAccount->credit >= $money) {
            $this->userAccount->update([
                'credit' => $this->userAccount->credit - $money,
                'balance' => $this->userAccount->credit - $this->userAccount->debt
            ]);
        } else {
            $this->userAccount->update([
                'debt' => $this->userAccount->debt + $money,
                'balance' => $this->userAccount->credit - $this->userAccount->debt
            ]);
        }
        if ($this->userAccount->debt < 0) {
            $this->userAccount->update([
                'credit' => $this->userAccount->credit - $this->userAccount->debt,
                'debt' => 0,
                'balance' => $this->userAccount->credit - $this->userAccount->debt
            ]);
        }
    }
}
