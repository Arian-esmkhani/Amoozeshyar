<?php

namespace App\Filament\Resources\TermAccessResource\Pages;

use App\Filament\Resources\TermAccessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

/**
 * کلاس نمایش لیست دسترسی‌های ترم‌های تحصیلی
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش جدول تمام دسترسی‌های تعریف شده برای ترم‌ها
 * - امکان فیلتر کردن بر اساس وضعیت فعال/غیرفعال
 * - مرتب‌سازی بر اساس تاریخ شروع و پایان
 * - نمایش وضعیت فعلی دسترسی هر ترم
 * - امکان ایجاد دسترسی جدید از طریق دکمه هدر
 *
 * نکته مهم: این صفحه دید کلی از وضعیت دسترسی تمام ترم‌ها را فراهم می‌کند
 *
 * @extends ListRecords کلاس پایه فیلامنت برای نمایش لیست رکوردها
 */
class ListTermAccesses extends ListRecords
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین صفحه لیست و منبع داده دسترسی‌های ترم را برقرار می‌کند
     */
    protected static string $resource = TermAccessResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای جدول را تعریف می‌کند
     * در حال حاضر شامل دکمه ایجاد دسترسی جدید برای ترم است
     *
     * @return array آرایه‌ای از دکمه‌های عملیات
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // افزودن دکمه ایجاد دسترسی جدید
        ];
    }
}