<?php

namespace App\Filament\Resources\LessonOfferedResource\Pages;

use App\Filament\Resources\LessonOfferedResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * کلاس ایجاد درس ارائه شده
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ایجاد درس ارائه شده جدید
 * - امکان ثبت اطلاعات درس شامل:
 *   - انتخاب درس از لیست دروس موجود
 *   - تعیین استاد درس
 *   - تعیین ظرفیت کلاس
 *   - تعیین زمان‌بندی کلاس (روز و ساعت)
 *   - تعیین نیمسال تحصیلی
 *   - تنظیم پیش‌نیازها و هم‌نیازها
 * - اعتبارسنجی داده‌های ورودی
 * - ذخیره‌سازی اطلاعات درس ارائه شده در دیتابیس
 *
 * نکته: این صفحه توسط مدیران آموزش برای تعریف دروس هر نیمسال استفاده می‌شود
 */
class CreateLessonOffered extends CreateRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ایجاد و منبع داده دروس ارائه شده را برقرار می‌کند
     */
    protected static string $resource = LessonOfferedResource::class;
}