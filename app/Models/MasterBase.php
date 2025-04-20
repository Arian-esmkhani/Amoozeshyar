<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//فرا خوانی مدل
use Illuminate\Database\Eloquent\SoftDeletes;//فرا خوانی سافت دیلیت

/**
 * کلاسی برای تعریف مدل بیس استاد
 */
class MasterBase extends Model
{
    //استفاده از حذف امن
    use SoftDeletes;

    //ارتباط با تیبل بیس استاد
    protected $table = 'master_base';

    //فیلد هایی که می توانند پر شوند
    protected $fillable =[
        'master_id',
        'master_name',
        'master_score',
        'users-save'
    ];

    //کاست کردن فیلد ها
    protected $casts = [
    ];
}