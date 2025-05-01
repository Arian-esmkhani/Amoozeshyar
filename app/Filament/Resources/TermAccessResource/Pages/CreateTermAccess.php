<?php

namespace App\Filament\Resources\TermAccessResource\Pages;

use App\Filament\Resources\TermAccessResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * کلاس ایجاد دسترسی جدید برای ترم تحصیلی
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم تنظیم دسترسی جدید برای ترم
 * - اعتبارسنجی تاریخ‌های شروع و پایان دسترسی
 * - تنظیم پیام‌های نمایشی برای کاربران
 * - ذخیره تنظیمات دسترسی در پایگاه داده
 *
 * نکته مهم: این بخش برای مدیریت زمان‌بندی دسترسی دانشجویان به ترم‌های تحصیلی استفاده می‌شود
 *
 * @extends CreateRecord کلاس پایه فیلامنت برای ایجاد رکورد جدید
 */
class CreateTermAccess extends CreateRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ایجاد و منبع داده دسترسی‌های ترم را برقرار می‌کند
     */
    protected static string $resource = TermAccessResource::class;
}
