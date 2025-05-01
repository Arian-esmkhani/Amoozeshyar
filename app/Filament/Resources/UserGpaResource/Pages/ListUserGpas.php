<?php

namespace App\Filament\Resources\UserGpaResource\Pages;

use App\Filament\Resources\UserGpaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

/**
 * کلاس نمایش لیست معدل‌های دانشجویان
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش جدول معدل‌های تمام دانشجویان
 * - امکان جستجو و فیلتر کردن معدل‌ها
 * - مرتب‌سازی بر اساس معیارهای مختلف
 * - امکان ایجاد رکورد معدل جدید از طریق دکمه هدر
 *
 * @extends ListRecords کلاس پایه فیلامنت برای نمایش لیست رکوردها
 */
class ListUserGpas extends ListRecords
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین صفحه لیست و منبع داده معدل‌ها را برقرار می‌کند
     */
    protected static string $resource = UserGpaResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای جدول را تعریف می‌کند
     * در حال حاضر شامل دکمه ایجاد معدل جدید است
     *
     * @return array آرایه‌ای از دکمه‌های عملیات
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // افزودن دکمه ایجاد معدل جدید
        ];
    }
}