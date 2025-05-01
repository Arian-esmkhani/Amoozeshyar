<?php

namespace App\Livewire; // تعریف فضای نام برای کامپوننت‌های Livewire

use Livewire\Component; // استفاده از کلاس Component از Livewire
use Illuminate\Support\Facades\Auth; // استفاده از Auth برای احراز هویت کاربر
class Amoozeshyar extends Component // تعریف کلاس Amoozeshyar که از Component ارث می‌برد
{
    public $userRole; // تعریف متغیر برای نقش کاربر
    public $isStudent = false; // تعریف متغیر برای بررسی وضعیت دانشجویی
    public $isTeacher = false; // تعریف متغیر برای بررسی وضعیت تدریس

    // متد mount که هنگام بارگذاری کامپوننت اجرا می‌شود
    public function mount($userRole)
    {
        $this->userRole = $userRole; // ذخیره نقش کاربر
        $this->isStudent = Auth::user()->isStudent(); // بررسی اینکه آیا کاربر دانشجو است
        $this->isTeacher = Auth::user()->isTeacher(); // بررسی اینکه آیا کاربر معلم است
    }

    // متد render که نمای مربوط به کامپوننت را برمی‌گرداند
    public function render()
    {
        return view('livewire.amoozeshyar'); // بازگشت به نمای amoozeshyar
    }
}

