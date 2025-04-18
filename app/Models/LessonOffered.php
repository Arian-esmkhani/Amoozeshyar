<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//فرا خوانی کلاس مدل از لاراول
use Illuminate\Database\Eloquent\SoftDeletes;//فرراخوانی کلاس حذف نرم از لاراول

/**
 * کلاسی برای تعریف مدل درس های اراعه شده
 */
class LessonOffered extends Model
{
    //حذف نرم برای اسستفاده ازش
    use SoftDeletes;

    //ارتباط با جدول درس های اراعه شده
    protected $table = 'lesten_offered';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'lesten_id',
        'lesten_name',
        'major',
        'lesten_master',
        'lesten_date',
        'lesten_sex',
        'lesten_final',
        'unit_count',
        'capacity',
        'registered_count',
        'lesten_price',
        'class_type',
        'classroom',
        'class_schedule',
        'prerequisites'
    ];

    //کاستینگ فیلد ها
    protected $casts = [
        'lesten_type' => 'string',
        'lesten_sex' => 'string',

    ];
}