<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//فرا خوانی مدل
use Illuminate\Database\Eloquent\SoftDeletes;//فرا خوانی حذف نرم

/**
 * کلاسی برای تعریف مدل بانک اکانت کاربر
 */
class UserAccount extends Model
{
    //استفاده از حذف نرم
    use SoftDeletes;

    //ارتباط با جدول یوزر اکانت
    protected $table = 'users_account';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'user_id',
        'balance',
        'debt',
        'credit',
        'payment_status'
    ];

    //کستینگ فیلد ها
    protected $casts = [
    ];

    //ارتیاط با یوزربیس از طریق یوزر آدی
    public function user()
    {
        return $this->belongsTo(UserBase::class, 'user_id');
    }
}