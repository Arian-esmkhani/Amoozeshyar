<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * مدل Slider برای مدیریت اسلایدرهای سیستم
 */
class Slider extends Model
{

    /**
     * فیلدهایی که قابل پر شدن هستند
     * @var array
     *
     * title: عنوان اسلایدر
     * description: توضیحات اسلایدر
     * image: مسیر تصویر اسلایدر
     * link: لینک مقصد اسلایدر
     * order: ترتیب نمایش اسلایدر
     * is_active: وضعیت فعال/غیرفعال بودن اسلایدر
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'order',
        'is_active',
        'type',
    ];
}
