<?php

namespace App\Filament\Resources\TermAccessResource\Pages;

use App\Filament\Resources\TermAccessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

/**
 * کلاس ویرایش دسترسی ترم تحصیلی
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ویرایش تنظیمات دسترسی ترم
 * - امکان تغییر تاریخ‌های شروع و پایان دسترسی
 * - بروزرسانی وضعیت فعال/غیرفعال بودن دسترسی
 * - ویرایش پیام‌های نمایشی برای کاربران
 * - امکان حذف دسترسی ترم از طریق دکمه هدر
 *
 * نکته مهم: تغییرات در این بخش مستقیماً بر دسترسی دانشجویان به ترم تأثیر می‌گذارد
 *
 * @extends EditRecord کلاس پایه فیلامنت برای ویرایش رکورد
 */
class EditTermAccess extends EditRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ویرایش و منبع داده دسترسی‌های ترم را برقرار می‌کند
     */
    protected static string $resource = TermAccessResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای فرم را تعریف می‌کند
     * در حال حاضر شامل دکمه حذف دسترسی ترم است
     * توجه: حذف دسترسی ترم باید با دقت انجام شود زیرا می‌تواند دسترسی دانشجویان را مسدود کند
     *
     * @return array آرایه‌ای از دکمه‌های عملیات
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(), // افزودن دکمه حذف به هدر صفحه
        ];
    }
}
