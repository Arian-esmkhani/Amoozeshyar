<?php

namespace App\Models;

use App\Enums\Permission as PermissionEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * مدل Permission برای مدیریت مجوزهای سیستم
 * این کلاس شامل مجوزهای مختلف برنامه است
 */
class Permission extends Model
{
    /**
     * فیلدهایی که قابل پر شدن هستند
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * تبدیل نام مجوز به نوع داده Enum
     * @return PermissionEnum
     */
    public function getEnumAttribute(): PermissionEnum
    {
        return PermissionEnum::from($this->name);
    }
}
