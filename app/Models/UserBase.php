<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;//استفاده از حس فکتوری
use Illuminate\Database\Eloquent\SoftDeletes;//استفاده از حذف امن
use Illuminate\Foundation\Auth\User as Authenticatable;//استفاده از سیستم احراز هویت
use Illuminate\Notifications\Notifiable;//استفاده  از کلاس اعلان
use Laravel\Sanctum\HasApiTokens;//استفاده از هس پی توکن

/**
 * تعریف یک کلاس برای کار با مدل یوزر بیس
 */
class UserBase extends Authenticatable
{
    //استفاده از قابلیت های فرا خوانده شده
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    //ارتباط با تیبل یوزر بیس
    protected $table = 'users_base';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    // فیلد هایی که باید هاید شوند
    protected $hidden = [
        'password',
    ];

    //کاست کردنداده  فیلد ها
    protected $casts = [
        'password' => 'hashed',
    ];

    //تعریف ثابت هایی که می توان به رول نسبت داد
    public const ROLE_ADMIN = 'admin';
    public const ROLE_TEACHER = 'teacher';
    public const ROLE_STUDENT = 'student';

    //یک متد استاتیک برای ساخت سلف هایی که می توان در متد های دیگر استفاده کرد
    public static function getRoles(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_TEACHER,
            self::ROLE_STUDENT,
        ];
    }

    // سه فاکشن عمومی که هرکدم برای استفاده از یک رول خولست است
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isTeacher(): bool
    {
        return $this->role === self::ROLE_TEACHER;
    }

    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }
}
