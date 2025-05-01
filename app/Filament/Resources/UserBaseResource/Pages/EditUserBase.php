<?php

namespace App\Filament\Resources\UserBaseResource\Pages;

use App\Filament\Resources\UserBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

/**
 * کلاس ویرایش اطلاعات کاربر پایه
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ویرایش اطلاعات کاربر
 * - اعتبارسنجی تغییرات در اطلاعات کاربر
 * - بروزرسانی اطلاعات کاربر در پایگاه داده
 * - امکان حذف کاربر از طریق دکمه هدر
 *
 * نکته امنیتی: فقط کاربران ادمین به این صفحه دسترسی دارند
 *
 * @extends EditRecord کلاس پایه فیلامنت برای ویرایش رکورد
 */
class EditUserBase extends EditRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ویرایش و منبع داده کاربران را برقرار می‌کند
     */
    protected static string $resource = UserBaseResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای فرم را تعریف می‌کند
     * در حال حاضر شامل دکمه حذف کاربر است
     * توجه: عملیات حذف نیاز به تأیید دارد و فقط توسط ادمین قابل انجام است
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
