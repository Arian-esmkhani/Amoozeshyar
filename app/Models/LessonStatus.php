<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; //فرا خوانی مدل
use Illuminate\Database\Eloquent\SoftDeletes; //فرا خوانی سافت دیلیت

/**
 * کلاسی برای تعریف مدل وضعیت درس
 */
class LessonStatus extends Model
{
    //استفاده از حذف امن
    use SoftDeletes;

    //ارتباط با تیبل وضعیت درس
    protected $table = 'lesson_status';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'lesson_id',
        'lesson_name',
        'student_name',
        'master_name',
        'lesson_score',
        'lesson_status'
    ];

    //کاست کردن فیلد ها
    protected $casts = [];
}
