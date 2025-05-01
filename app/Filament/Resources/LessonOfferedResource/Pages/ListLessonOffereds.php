<?php

namespace App\Filament\Resources\LessonOfferedResource\Pages;

use App\Filament\Resources\LessonOfferedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

/**
 * کلاس نمایش لیست دروس ارائه شده
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش جدول تمامی دروس ارائه شده در نیمسال‌های تحصیلی
 * - امکانات مدیریتی شامل:
 *   - مشاهده اطلاعات کامل هر درس (نام، کد، استاد، ظرفیت و...)
 *   - فیلتر کردن دروس بر اساس:
 *     - نیمسال تحصیلی
 *     - گروه آموزشی
 *     - استاد
 *     - وضعیت (فعال/غیرفعال)
 *   - جستجو در دروس
 *   - مرتب‌سازی بر اساس فیلدهای مختلف
 * - امکان ایجاد درس ارائه شده جدید از طریق دکمه هدر
 *
 * نکته: این صفحه ابزار اصلی مدیران آموزش برای مدیریت دروس ارائه شده است
 */
class ListLessonOffereds extends ListRecords
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین صفحه لیست و منبع داده دروس ارائه شده را برقرار می‌کند
     */
    protected static string $resource = LessonOfferedResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای جدول را تعریف می‌کند
     * شامل دکمه ایجاد درس ارائه شده جدید است
     * این دکمه مدیران را به فرم ایجاد درس جدید هدایت می‌کند
     *
     * @return array آرایه‌ای از دکمه‌های عملیات
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // افزودن دکمه ایجاد به هدر صفحه
        ];
    }
}
