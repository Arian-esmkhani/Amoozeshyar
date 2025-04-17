<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//فرا خوانی کلاس مدل از لاراول
use Illuminate\Database\Eloquent\SoftDeletes;//فرراخوانی کلاس حذف نرم از لاراول

/**
 * کلاسی برای تعریف مدل درس های اراعه شده
 */
class LessonOffered extends Model
{
    //حذف نرم برای اسستفاده ازش
    use SoftDeletes;

    //ارتباط با جدول درس های اراعه شده
    protected $table = 'lesten_offered';

    //فیلد هایی که می توانند پر شوند
    protected $fillable = [
        'lesten_id',
        'lesten_name',
        'major',
        'lesten_master',
        'lesten_date',
        'lesten_sex',
        'lesten_final',
        'unit_count',
        'capacity',
        'registered_count',
        'lesten_price',
        'class_type',
        'classroom',
        'class_schedule',
        'prerequisites'
    ];

    //کاستینگ فیلد ها
    protected $casts = [
        'lesten_type' => 'string',
        'lesten_sex' => 'string',

    ];

    //تعریف ثابت هایی که می توان به رشته(ماژور) نسبت داد
    public const TYPE_GENERAL = 'عمومی';
    public const TYPE_ENGINIER = 'مهندسی';
    public const TYPE_GENERALCUM = 'علوم کامپیوتر';
    public const TYPE_ENGINIERCUM = 'مهندسی کامپیوتر';

    //یک متد استاتیک برای ساخت سلف هایی که می توان در متد های دیگر استفاده کرد
    public static function getMajor(): array
    {
        return [
            self::TYPE_GENERAL,
            self::TYPE_ENGINIER,
            self::TYPE_GENERALCUM,
            self::TYPE_ENGINIERCUM,
        ];
    }

    //فاکشن هایی برای استفاده چندباره از این اطلاعات
    public function isGeneral(): bool
    {
        return $this->major=== self::TYPE_GENERAL;
    }

    public function isEnginier(): bool
    {
        return $this->major === self::TYPE_ENGINIER;
    }

    public function isGeneralCum(): bool
    {
        return $this->major=== self::TYPE_GENERALCUM;
    }

    public function isEnginierCum(): bool
    {
        return $this->major === self::TYPE_ENGINIERCUM;
    }

    //تعریف ثابت هایی که می توان به جنسیت نسبت داد
    public const SEX_OPEN = 'open';
    public const SEX_MALE = 'male';
    public const SEX_FEMALE = 'female';

    //یک متد استاتیک برای ساخت سلف هایی که می توان در متد های دیگر استفاده کرد
    public static function getSex(): array
    {
        return [
            self::SEX_OPEN,
            self::SEX_MALE,
            self::SEX_FEMALE,
        ];
    }

    //فاکشن هایی برای استفاده چندباره از این اطلاعات
    public function isOpen(): bool
    {
        return $this->lesten_sex === self::SEX_OPEN;
    }

    public function isMale(): bool
    {
        return $this->rlesten_sex === self::SEX_MALE;
    }

    public function isFemale(): bool
    {
        return $this->lesten_sex === self::SEX_FEMALE;
    }
}