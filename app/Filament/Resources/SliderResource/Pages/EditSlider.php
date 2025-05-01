<?php

namespace App\Filament\Resources\SliderResource\Pages;

use App\Filament\Resources\SliderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

/**
 * کلاس ویرایش اسلایدر
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ویرایش اطلاعات اسلایدر
 * - امکان تغییر تصویر اسلایدر
 * - ویرایش عنوان، توضیحات و لینک
 * - تغییر ترتیب نمایش و وضعیت فعال/غیرفعال
 * - امکان حذف اسلایدر از طریق دکمه هدر
 *
 * نکته: در صورت تغییر تصویر، فایل قدیمی به صورت خودکار حذف می‌شود
 *
 * @extends EditRecord کلاس پایه فیلامنت برای ویرایش رکورد
 */
class EditSlider extends EditRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ویرایش و منبع داده اسلایدرها را برقرار می‌کند
     */
    protected static string $resource = SliderResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای فرم را تعریف می‌کند
     * در حال حاضر شامل دکمه حذف اسلایدر است
     * توجه: حذف اسلایدر باعث حذف تصویر مرتبط نیز می‌شود
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
