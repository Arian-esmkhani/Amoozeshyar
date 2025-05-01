<?php

namespace App\Filament\Resources\SliderResource\Pages;

use App\Filament\Resources\SliderResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * کلاس ایجاد اسلایدر جدید
 *
 * این کلاس مسئولیت‌های زیر را بر عهده دارد:
 * - نمایش فرم ایجاد اسلایدر جدید
 * - مدیریت آپلود تصویر اسلایدر
 * - اعتبارسنجی اطلاعات ورودی (عنوان، توضیحات، لینک)
 * - تنظیم ترتیب نمایش و وضعیت فعال/غیرفعال
 * - ذخیره اطلاعات اسلایدر در پایگاه داده
 *
 * نکته: تصاویر آپلود شده در پوشه 'sliders' ذخیره می‌شوند
 *
 * @extends CreateRecord کلاس پایه فیلامنت برای ایجاد رکورد جدید
 */
class CreateSlider extends CreateRecord
{
    /**
     * مشخص کردن کلاس Resource مرتبط
     * این متغیر ارتباط بین فرم ایجاد و منبع داده اسلایدرها را برقرار می‌کند
     */
    protected static string $resource = SliderResource::class;
}
