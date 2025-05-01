<?php

namespace App\Filament\Resources\LoginHistoryResource\Pages;

use App\Filament\Resources\LoginHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

/**
 * کلاس نمایش لیست سوابق ورود کاربران
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش جدول تمامی سوابق ورود کاربران به سیستم
 * - امکان مشاهده جزئیات هر ورود شامل:
 *   - زمان ورود و خروج
 *   - آدرس IP کاربر
 *   - نوع مرورگر و دستگاه
 *   - وضعیت موفقیت یا شکست ورود
 * - امکان فیلتر کردن بر اساس تاریخ، کاربر، وضعیت و...
 * - امکان جستجو در سوابق
 * - امکان ایجاد سابقه ورود جدید (معمولاً برای موارد خاص یا تست)
 *
 * نکته: این صفحه برای مدیران سیستم و تیم امنیت جهت بررسی فعالیت‌های کاربران مفید است
 */
class ListLoginHistories extends ListRecords
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین صفحه لیست و منبع داده سوابق ورود را برقرار می‌کند
     */
    protected static string $resource = LoginHistoryResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای جدول را تعریف می‌کند
     * شامل دکمه ایجاد سابقه ورود جدید است
     * توجه: معمولاً سوابق ورود به صورت خودکار توسط سیستم ثبت می‌شوند
     * و نیازی به ثبت دستی نیست مگر در موارد خاص
     *
     * @return array آرایه‌ای از دکمه‌های عملیات
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // افزودن دکمه ایجاد به هدر صفحه
        ];
    }
}
