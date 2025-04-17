<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * کلاس کامپوننت انتخاب واحد
 *
 * این کامپوننت برای مدیریت فرآیند انتخاب واحد دانشجویان استفاده می‌شود
 * شامل قابلیت‌های زیر است:
 * - نمایش لیست دروس قابل انتخاب
 * - انتخاب و حذف دروس
 * - محاسبه تعداد واحدها
 * - بررسی محدودیت‌های انتخاب واحد
 * - نمایش جزئیات هر درس
 * - ثبت نهایی دروس انتخاب شده
 */
class EntekhabVahed extends Component
{
    /**
     * حداقل واحد مجاز برای انتخاب
     * @var int
     * این مقدار از تنظیمات سیستم دریافت می‌شود
     */
    public $minUnits;

    /**
     * حداکثر واحد مجاز برای انتخاب
     * @var int
     * این مقدار از تنظیمات سیستم دریافت می‌شود
     */
    public $maxUnits;

    /**
     * لیست تمام دروس ارائه شده در ترم جاری
     * @var Collection
     * شامل اطلاعات کامل هر درس مانند نام، استاد، زمان و ظرفیت
     */
    public $lessons;

    /**
     * آرایه دروس انتخاب شده
     * @var array
     * هر عنصر این آرایه شامل شناسه (ID) درس انتخاب شده است
     */
    public $selectedLessons = [];

    /**
     * درس انتخاب شده برای نمایش جزئیات
     * @var object|null
     * شامل اطلاعات کامل درس انتخاب شده
     */
    public $selectedLesson = null;

    /**
     * تعداد کل واحدهای انتخاب شده
     * @var int
     * این متغیر به صورت خودکار با تغییر دروس انتخاب شده به‌روز می‌شود
     */
    public $totalUnits = 0;

    /**
     * حزینه کل دروس
     * @var int
     * این متغیر به صورت خودکار با تغییر دروس انتخاب شده بروز می شود
     */
    public $totalDebt = 0;

    /**
     * وضعیت نمایش لیست دروس
     * @var bool
     * true: لیست دروس نمایش داده می‌شود
     * false: لیست دروس مخفی است
     */
    public $showLessonList = false;

    /**
     * وضعیت نمایش جزئیات درس
     * @var bool
     * true: جزئیات درس نمایش داده می‌شود
     * false: جزئیات درس مخفی است
     */
    public $showLessonDetails = false;

    /**
     * متد مقداردهی اولیه کامپوننت
     *
     * این متد در زمان ایجاد کامپوننت اجرا می‌شود
     * و مقادیر اولیه را تنظیم می‌کند
     *
     * @param array $data داده‌های مورد نیاز شامل:
     *                    - minMax: محدوده مجاز واحدها
     *                    - lessonOffered: لیست دروس ارائه شده
     */
    public function mount($data)
    {
        $this->minUnits = $data['minMax']->min_unit;
        $this->maxUnits = $data['minMax']->max_unit;
        $this->lessons = $data['lessonOffered'];
    }

    /**
     * متد تغییر وضعیت انتخاب یک درس
     *
     * این متد در زمان کلیک روی دکمه انتخاب/حذف درس اجرا می‌شود
     * و عملیات زیر را انجام می‌دهد:
     * - بررسی محدودیت تعداد واحد
     * - بررسی ظرفیت کلاس
     * - اضافه یا حذف درس از لیست انتخاب شده
     *
     * @param int $lessonId شناسه درس مورد نظر
     */
    public function toggleLesson($lessonId)
    {
        //برسی اگر درس قبلا انتخاب شده باشد
        if (in_array($lessonId, $this->selectedLessons)) {
            $this->selectedLessons = array_diff($this->selectedLessons, [$lessonId]);
        //اگر درس قبلا انتخاب نشده باشد
        } else {
            //درس را از لیست دروس انتخاب کنیم
            $lesson = $this->lessons->firstWhere('id', $lessonId);
            //محاسبه تعداد کل واحدهای انتخاب شده
            $newTotalUnits = $this->totalUnits + $lesson->unit_count;
            //بررسی اگر تعداد واحدهای انتخاب شده از حداکثر واحد مجاز بیشتر باشد
            if ($newTotalUnits > $this->maxUnits) {
                $this->dispatch('show-message', [
                    'type' => 'error',
                    'message' => "با انتخاب این درس از سقف مجاز واحد ({$this->maxUnits}) بیشتر می‌شود."
                ]);
                return;
            }

            //بررسی اگر ظرفیت کلاس تکمیل شده باشد
            if ($lesson->capacity <= $lesson->registered_count) {
                $this->dispatch('show-message', [
                    'type' => 'error',
                    'message' => "ظرفیت این درس تکمیل شده است."
                ]);
                return;
            }
            //درس را به لیست دروس انتخاب شده اضافه کنیم
            $this->selectedLessons[] = $lessonId;
        }
        //محاسبه تعداد کل واحدهای انتخاب شده
        $this->calculateTotalUnits();

        //محاسبه حزینه کل دروس
        $this->calculateTotalDebt();

        //جزئیات درس را مخفی کنیم
        $this->showLessonDetails = false;
    }

    /**
     * محاسبه تعداد کل واحدهای انتخاب شده
     *
     * این متد پس از هر تغییر در لیست دروس انتخاب شده
     * تعداد کل واحدها را محاسبه می‌کند
     */
    protected function calculateTotalUnits()
    {
        //محاسبه تعداد کل واحدهای انتخاب شده
        $this->totalUnits = $this->lessons->whereIn('id', $this->selectedLessons)->sum('unit_count');
    }

    /**
     * محاسبه حزینه کل دروس
     *
     * این متد پس از هر تغییر در لیست دروس انتخاب شده
     * هزینه کلوا برای دروس انتخاب شده را محاسبه می‌کند
     */
    protected function calculateTotalDebt()
    {
        $this->totalDebt = $this->lessons->whereIn('id', $this->selectedLessons)->sum('debt');
    }


    /**
     * نمایش جزئیات یک درس
     *
     * این متد در زمان کلیک روی نام درس اجرا می‌شود
     * و جزئیات کامل درس را نمایش می‌دهد
     *
     * @param int $lessonId شناسه درس مورد نظر
     */
    public function showLessonDetails($lessonId)
    {
        $this->selectedLesson = $this->lessons->firstWhere('id', $lessonId);
        $this->showLessonDetails = true;
        $this->showLessonList = false;
    }

    /**
     * ثبت نهایی دروس انتخاب شده
     *
     * این متد در زمان کلیک روی دکمه ثبت نهایی اجرا می‌شود
     * و عملیات زیر را انجام می‌دهد:
     * - بررسی محدودیت‌های انتخاب واحد
     * - ذخیره دروس انتخاب شده در دیتابیس
     * - نمایش پیام موفقیت یا خطا
     */
    public function submit()
    {
        if ($this->totalUnits < $this->minUnits) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => "حداقل {$this->minUnits} واحد باید انتخاب کنید."
            ]);
            return;
        }

        if ($this->totalUnits > $this->maxUnits) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => "حداکثر {$this->maxUnits} واحد می‌توانید انتخاب کنید."
            ]);
            return;
        }

        // TODO: ذخیره دروس انتخاب شده در دیتابیس
        $this->dispatch('show-message', [
            'type' => 'success',
            'message' => 'دروس با موفقیت ثبت شدند.'
        ]);
    }

    /**
     * رندر کردن ویو
     *
     * این متد صفحه انتخاب واحد را رندر می‌کند
     * و تمام داده‌های مورد نیاز را به ویو ارسال می‌کند
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.entekhab-vahed');
    }
}