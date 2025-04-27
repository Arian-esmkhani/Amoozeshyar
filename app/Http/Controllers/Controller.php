<?php

namespace App\Http\Controllers; // تعریف فضای نام برای کنترلرها

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // استفاده از قابلیت مجوزدهی
use Illuminate\Foundation\Validation\ValidatesRequests; // استفاده از قابلیت اعتبارسنجی
use Illuminate\Routing\Controller as BaseController; // استفاده از کنترلر پایه

// این کلاس یک کلاس  است که از BaseController ارث‌بری می‌کند
abstract class Controller extends BaseController
{
    // اینجا قابلیت‌های مجوزدهی و اعتبارسنجی را به کلاس اضافه می‌کنیم
    use AuthorizesRequests, ValidatesRequests;
}

