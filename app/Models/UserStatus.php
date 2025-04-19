<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; //فرا خوانی مدل
use Illuminate\Database\Eloquent\SoftDeletes; //فرا خوانی سافت دیلیت

/**
 * کلاسی برای تعریف مدل وضعیت کاربر
 */
class UserStatus extends Model
{
    //استفاده از حذف امن
    use SoftDeletes;

    //ارتباط با تیبل وضعیت کاربر
    protected $table = 'user_status';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'user_id',
        'min_unit',
        'max_unit',
        'passed_units',
        'loss_units',
        'unit_interm',
        'unit_intership',
        'free_unit',
        'pass_term',
        'take_listen',
        'allowed_term',
        'student_status',
        'can_take_courses',
        'academic_notes',
        'term',
        'lost_term'
    ];

    //کاست کردن فیلد ها
    protected $casts = [
        'can_take_courses' => 'boolean',
        'take_listen' => 'json'
    ];

    //ارتباط با جدول یوزر بیس از طریق یوزر آی دی
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
