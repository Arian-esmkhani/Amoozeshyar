<?php

namespace App\Filament\Resources\LoginHistoryResource\Pages;

use App\Filament\Resources\LoginHistoryResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * کلاس ایجاد سابقه ورود جدید
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ثبت سابقه ورود جدید
 * - ثبت اطلاعات ورود کاربر شامل:
 *   - شناسه کاربر
 *   - تاریخ و زمان ورود
 *   - آدرس IP
 *   - نوع دستگاه و مرورگر
 *   - وضعیت موفقیت/شکست ورود
 *
 * نکته: معمولاً این کلاس به صورت خودکار توسط سیستم استفاده می‌شود
 * و نیازی به ایجاد دستی سابقه ورود نیست
 *
 * @extends CreateRecord کلاس پایه فیلامنت برای ایجاد رکورد جدید
 */
class CreateLoginHistory extends CreateRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ایجاد و منبع داده سوابق ورود را برقرار می‌کند
     */
    protected static string $resource = LoginHistoryResource::class;
}