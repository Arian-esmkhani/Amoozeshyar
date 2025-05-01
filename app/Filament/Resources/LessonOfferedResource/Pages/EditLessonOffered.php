<?php

namespace App\Filament\Resources\LessonOfferedResource\Pages;

use App\Filament\Resources\LessonOfferedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

/**
 * کلاس ویرایش درس ارائه شده
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ویرایش اطلاعات درس ارائه شده
 * - امکان تغییر موارد زیر:
 *   - تغییر استاد درس
 *   - تغییر ظرفیت کلاس
 *   - تغییر زمان‌بندی کلاس
 *   - تغییر وضعیت درس (فعال/غیرفعال)
 *   - بروزرسانی پیش‌نیازها و هم‌نیازها
 * - اعتبارسنجی تغییرات
 * - ذخیره‌سازی تغییرات در دیتابیس
 * - امکان حذف درس ارائه شده از طریق دکمه هدر
 *
 * نکته مهم: تغییرات در دروس ارائه شده باید با دقت انجام شود
 * زیرا ممکن است بر برنامه درسی دانشجویان تأثیر بگذارد
 */
class EditLessonOffered extends EditRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ویرایش و منبع داده دروس ارائه شده را برقرار می‌کند
     */
    protected static string $resource = LessonOfferedResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای فرم را تعریف می‌کند
     * شامل دکمه حذف درس ارائه شده است
     * هشدار: حذف درس ارائه شده باید با احتیاط انجام شود
     * زیرا ممکن است دانشجویانی این درس را انتخاب کرده باشند
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
