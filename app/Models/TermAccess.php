<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * مدل TermAccess برای مدیریت دسترسی به ترم‌های تحصیلی
 * این کلاس امکان کنترل دسترسی به ترم‌ها را بر اساس زمان و وضعیت فعال بودن فراهم می‌کند
 */
class TermAccess extends Model
{


    /**
     * فیلدهایی که قابل پر شدن هستند
     * @var array
     *
     * term_number: شماره ترم تحصیلی
     * is_active: وضعیت فعال بودن دسترسی
     * start_date: تاریخ شروع دسترسی
     * end_date: تاریخ پایان دسترسی
     * message: پیام نمایشی برای کاربران
     */
    protected $fillable = [
        'term_number',
        'is_active',
        'start_date',
        'end_date',
        'message'
    ];

    /**
     * تبدیل خودکار نوع داده‌های فیلدها
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /**
     * بررسی می‌کند که آیا در حال حاضر دسترسی به ترم امکان‌پذیر است یا خیر
     *
     * شرایط دسترسی:
     * 1. دسترسی باید فعال باشد (is_active = true)
     * 2. تاریخ فعلی باید بعد از تاریخ شروع باشد (اگر تعیین شده باشد)
     * 3. تاریخ فعلی باید قبل از تاریخ پایان باشد (اگر تعیین شده باشد)
     *
     * @return bool نتیجه بررسی دسترسی
     */
    public function isAccessible()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($this->start_date && $now < $this->start_date) {
            return false;
        }

        if ($this->end_date && $now > $this->end_date) {
            return false;
        }

        return true;
    }
}
