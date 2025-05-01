<?php

namespace App\Filament\Resources\LoginHistoryResource\Pages;

use App\Filament\Resources\LoginHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

/**
 * کلاس ویرایش سابقه ورود کاربر
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ویرایش سابقه ورود
 * - امکان تصحیح اطلاعات ثبت شده شامل:
 *   - زمان ورود و خروج
 *   - وضعیت ورود
 *   - دلیل شکست (در صورت وجود)
 *   - اطلاعات IP و مرورگر
 * - امکان حذف سابقه ورود از طریق دکمه هدر
 *
 * نکته امنیتی: هرگونه تغییر در سوابق ورود باید با دقت و توسط افراد مجاز انجام شود
 * زیرا این تغییرات می‌تواند بر گزارش‌های امنیتی تأثیرگذار باشد
 *
 * @extends EditRecord کلاس پایه فیلامنت برای ویرایش رکورد
 */
class EditLoginHistory extends EditRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ویرایش و منبع داده سوابق ورود را برقرار می‌کند
     */
    protected static string $resource = LoginHistoryResource::class;

    /**
     * تعریف دکمه‌های عملیات در هدر صفحه
     *
     * این متد دکمه‌های موجود در بالای فرم را تعریف می‌کند
     * در حال حاضر شامل دکمه حذف سابقه ورود است
     * توجه: حذف سوابق ورود باید با احتیاط انجام شود زیرا بر تاریخچه امنیتی تأثیر می‌گذارد
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
