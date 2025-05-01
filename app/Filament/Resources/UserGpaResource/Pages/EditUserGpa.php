<?php

namespace App\Filament\Resources\UserGpaResource\Pages;

use App\Filament\Resources\UserGpaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

/**
 * کلاس ویرایش معدل دانشجو
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ویرایش معدل دانشجو
 * - اعتبارسنجی تغییرات اعمال شده
 * - بروزرسانی اطلاعات معدل در پایگاه داده
 * - امکان حذف رکورد معدل از طریق دکمه هدر
 *
 * @extends EditRecord کلاس پایه فیلامنت برای ویرایش رکورد
 */
class EditUserGpa extends EditRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ویرایش و منبع داده معدل‌ها را برقرار می‌کند
     */
    protected static string $resource = UserGpaResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای فرم را تعریف می‌کند
     * در حال حاضر شامل دکمه حذف معدل است
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
