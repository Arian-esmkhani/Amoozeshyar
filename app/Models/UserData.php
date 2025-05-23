<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//فرا خوانی مدل
use Illuminate\Database\Eloquent\SoftDeletes;//فرا خوانی سافت دیلیت

/**
 * کلاسی برای تعریف مدل اطلاعات کاربر
 */
class UserData extends Model
{
    //استفاده از حذف امن
    use SoftDeletes;

    //ارتباط با تیبل اطلاعات کاربر
    protected $table = 'users_data';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'user_id',
        'name',
        'father_name',
        'national_code',
        'birth_date',
        'gender',
        'religion',
        'denomination',
        'health_status',
        'address',
        'phone_number',
        'emergency_contact'
    ];

    //کاست کردن فیلد ها
    protected $casts = [
        'birth_date' => 'date'
    ];

    //ارتباط با جدول یوزر بیس از طریق یوزر آی دی
    public function user()
    {
        return $this->belongsTo(UserBase::class, 'user_id');
    }
}