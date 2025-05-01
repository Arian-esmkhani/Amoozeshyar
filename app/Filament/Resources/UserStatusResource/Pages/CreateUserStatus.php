<?php

namespace App\Filament\Resources\UserStatusResource\Pages;

use App\Filament\Resources\UserStatusResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * کلاس صفحه ایجاد وضعیت تحصیلی جدید برای دانشجو
 *
 * این کلاس مسئول نمایش و مدیریت فرم ایجاد وضعیت تحصیلی جدید است
 * از کلاس پایه CreateRecord فیلامنت ارث‌بری می‌کند که امکانات پایه ایجاد رکورد را فراهم می‌کند
 */
class CreateUserStatus extends CreateRecord
{
    /**
     * تعیین کلاس Resource مرتبط با این صفحه
     * این متغیر مشخص می‌کند که این صفحه با کدام Resource کار می‌کند
     */
    protected static string $resource = UserStatusResource::class;
}