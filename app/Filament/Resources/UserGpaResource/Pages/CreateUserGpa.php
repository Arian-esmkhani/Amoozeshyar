<?php

namespace App\Filament\Resources\UserGpaResource\Pages;

use App\Filament\Resources\UserGpaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

/**
 * کلاس ایجاد معدل جدید برای دانشجو
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ثبت معدل جدید
 * - اعتبارسنجی داده‌های ورودی
 * - ذخیره اطلاعات معدل در پایگاه داده
 *
 * @extends CreateRecord کلاس پایه فیلامنت برای ایجاد رکورد جدید
 */
class CreateUserGpa extends CreateRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ایجاد و منبع داده معدل‌ها را برقرار می‌کند
     */
    protected static string $resource = UserGpaResource::class;
}
