<?php

namespace App\Filament\Resources\UserStatusResource\Pages;

use App\Filament\Resources\UserStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

/**
 * کلاس نمایش لیست وضعیت‌های تحصیلی دانشجویان
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش جدول وضعیت‌های تحصیلی
 * - امکان جستجو و فیلتر کردن رکوردها
 * - امکان ایجاد وضعیت تحصیلی جدید از طریق دکمه هدر
 *
 * @extends ListRecords کلاس پایه فیلامنت برای نمایش لیست رکوردها
 */
class ListUserStatuses extends ListRecords
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین صفحه لیست و منبع داده را برقرار می‌کند
     */
    protected static string $resource = UserStatusResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای جدول را تعریف می‌کند
     * در حال حاضر شامل دکمه ایجاد رکورد جدید است
     *
     * @return array آرایه‌ای از دکمه‌های عملیات
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // افزودن دکمه ایجاد رکورد جدید
        ];
    }
}
