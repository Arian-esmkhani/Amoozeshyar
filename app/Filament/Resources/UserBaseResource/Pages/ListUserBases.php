<?php

namespace App\Filament\Resources\UserBaseResource\Pages;

use App\Filament\Resources\UserBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

/**
 * کلاس نمایش لیست کاربران پایه سیستم
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش جدول کاربران سیستم
 * - امکان جستجو در لیست کاربران
 * - فیلتر کردن کاربران بر اساس نقش و وضعیت
 * - مرتب‌سازی بر اساس معیارهای مختلف
 * - امکان ایجاد کاربر جدید از طریق دکمه هدر
 *
 * نکته امنیتی: فقط کاربران ادمین به این صفحه دسترسی دارند
 *
 * @extends ListRecords کلاس پایه فیلامنت برای نمایش لیست رکوردها
 */
class ListUserBases extends ListRecords
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین صفحه لیست و منبع داده کاربران را برقرار می‌کند
     */
    protected static string $resource = UserBaseResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای جدول را تعریف می‌کند
     * در حال حاضر شامل دکمه ایجاد کاربر جدید است
     * توجه: ایجاد کاربر جدید فقط توسط ادمین امکان‌پذیر است
     *
     * @return array آرایه‌ای از دکمه‌های عملیات
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // افزودن دکمه ایجاد کاربر جدید
        ];
    }
}
