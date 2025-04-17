<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//فرا خوانی مدل
use Illuminate\Database\Eloquent\SoftDeletes;//فرا خوانی سافت دیلیت

/**
 * کلاسی برای تعریف مدل وضعیت تحصیلی کاربر
 */
class UserGpa extends Model
{
    //استفاده از حذف امن
    use SoftDeletes;

    //ارتباط با تیبل وضعیت تحصیلی کاربر
    protected $table = 'users_gpa';

    //فیلد هایی که می توانند پر شوند
    protected $fillable =[
        'user_id',
        'semester_gpa',
        'last_gpa',
        'cumulative_gpa',
        'major_gpa',
        'general_gpa',
        'total_unitd',
        'passed_listen',
        'academic_status'
    ];

    //کاست کردن فیلد ها
    protected $casts = [
    ];

    //ارتباط با جدول یوزر بیس از طریق یوزر آی دی
    public function user()
    {
        return $this->belongsTo(UserBase::class, 'user_id');
    }
}
