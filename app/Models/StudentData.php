<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//فرا خوانی کلاس مدل از لاراول
use Illuminate\Database\Eloquent\SoftDeletes;//فرا خوانی کلاس حذف امن از لاراول

/**
 * کلاسی برای تعریف مدل اطلاعات دانش آموز
 */
class StudentData extends Model
{
    //استفاده از حذف امن
    use SoftDeletes;

    //ارتباط گرفتن با جدول اطلاعات دانش آموز
    protected $table = 'student_data';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'user_id',
        'enrollment_date',
        'student_number',
        'degree_level',
        'major'
    ];

    //کاست کردن فیلد ها
    protected $casts = [
    ];

    //ارتباط یا جدول یوربی از طریق یوزر آی دی 
    public function user()
    {
        return $this->belongsTo(UserBase::class, 'user_id');
    }
}
