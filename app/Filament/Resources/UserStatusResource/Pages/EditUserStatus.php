<?php

namespace App\Filament\Resources\UserStatusResource\Pages;

use App\Filament\Resources\UserStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

/**
 * کلاس مدیریت صفحه ویرایش وضعیت تحصیلی دانشجو
 *
 * این کلاس امکانات زیر را فراهم می‌کند:
 * - نمایش فرم ویرایش وضعیت تحصیلی
 * - ذخیره تغییرات اعمال شده
 * - امکان حذف رکورد از طریق دکمه هدر
 *
 * @extends EditRecord کلاس پایه فیلامنت برای ویرایش رکوردها
 */
class EditUserStatus extends EditRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین صفحه ویرایش و منبع داده را برقرار می‌کند
     */
    protected static string $resource = UserStatusResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های عملیات موجود در بالای صفحه را تعریف می‌کند
     * در حال حاضر فقط شامل دکمه حذف است که امکان حذف رکورد را فراهم می‌کند
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
