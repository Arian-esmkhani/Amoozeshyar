<?php

namespace App\Filament\Resources\UserBaseResource\Pages;

use App\Filament\Resources\UserBaseResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * کلاس ایجاد کاربر پایه جدید در سیستم
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ثبت کاربر جدید
 * - اعتبارسنجی اطلاعات ورودی (نام کاربری، ایمیل، رمز عبور)
 * - ذخیره اطلاعات کاربر جدید در پایگاه داده
 * - تنظیم سطح دسترسی و نقش کاربر
 *
 * نکته: این صفحه فقط توسط کاربران ادمین قابل دسترسی است
 *
 * @extends CreateRecord کلاس پایه فیلامنت برای ایجاد رکورد جدید
 */
class CreateUserBase extends CreateRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ایجاد و منبع داده کاربران را برقرار می‌کند
     */
    protected static string $resource = UserBaseResource::class;
}
