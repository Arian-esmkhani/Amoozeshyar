<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;// قراخوانی حس فکتوری
use Illuminate\Database\Eloquent\Model;//فراخوانی کلاس مدل از لاراول
use Illuminate\Database\Eloquent\SoftDeletes;//فرا خوانی کلاس حذف نرم از لاراول

/**
 * کلاسی برای تعریف مدل تاریخ لاگین
 */
class LoginHistory extends Model
{
    //استفاده از حس فکتوری و سافت دلیت
    use HasFactory, SoftDeletes;

    //ارتباط با جدول لاگین هیستوری
    protected $table = 'login_history';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'user_id',
        'login_time',
        'logout_at',
        'ip_address',
        'user_agent',
        'status',
        'failure_reason',
        'is_active',
        'last_login_at'
    ];

    //کاست کردن فیلد ها
    protected $casts = [
        'login_time' => 'datetime',
        'logout_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    //ارتباط با جدول یوزر  بیس از طریق یوزر آدی
    public function user()
    {
        return $this->belongsTo(UserBase::class, 'user_id');
    }
}
