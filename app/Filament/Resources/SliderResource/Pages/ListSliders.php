<?php

namespace App\Filament\Resources\SliderResource\Pages;

use App\Filament\Resources\SliderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

/**
 * کلاس نمایش لیست اسلایدرها
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش جدول تمام اسلایدرهای موجود
 * - نمایش پیش‌نمایش تصاویر اسلایدرها
 * - امکان مرتب‌سازی بر اساس ترتیب نمایش
 * - فیلتر کردن بر اساس وضعیت فعال/غیرفعال
 * - جستجو در عناوین و توضیحات اسلایدرها
 * - امکان ایجاد اسلایدر جدید از طریق دکمه هدر
 *
 * نکته: این صفحه دید کلی از تمام اسلایدرهای سایت را فراهم می‌کند
 *
 * @extends ListRecords کلاس پایه فیلامنت برای نمایش لیست رکوردها
 */
class ListSliders extends ListRecords
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین صفحه لیست و منبع داده اسلایدرها را برقرار می‌کند
     */
    protected static string $resource = SliderResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای جدول را تعریف می‌کند
     * در حال حاضر شامل دکمه ایجاد اسلایدر جدید است
     *
     * @return array آرایه‌ای از دکمه‌های عملیات
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // افزودن دکمه ایجاد اسلایدر جدید
        ];
    }
}
