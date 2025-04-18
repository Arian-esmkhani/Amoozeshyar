<?php

namespace App\Services;

use App\Models\UserAccount;
use Illuminate\Support\Facades\Auth;//استفاده از اوچیکیشن

//با این کلاس سرویس کار با بخش مالی کار بر را میسازیم
class AccountService
{
    //این متغیر برای ذخیره حساب کاربر است
    protected $userAccount;

    //این کانستراکتور برای ذخیره حساب کاربر است
    public function __construct()
    {
        $this->userAccount = UserAccount::where('user_id',Auth::user()->id)->first();
    }

    //این متد برای وقتی است که به هزینه های کاربر اضافه می شود
    public function UbdateDebt($money)
    {
        $this->userAccount->update([
            'debt' => $this->userAccount->debt + $money,
            'balance' => $this->userAccount->credit - $this->userAccount->debt
        ]);
        if($this->userAccount->debt < 0){
            $this->userAccount->update([
                'credit' => $this->userAccount->credit - $this->userAccount->debt,
                'debt' => 0,
                'balance' => $this->userAccount->credit
            ]);
        }
    }
}