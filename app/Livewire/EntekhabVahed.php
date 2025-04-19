<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\AccountService;
use App\Models\LessonStatus;

//کلاس ایجاد کامپننت انتخاب واحد
class EntekhabVahed extends Component
{
    //این متغیر برای سرویس کار با بخش مالی کار بر است
    protected $accountService;

    //این کانستراکتور برای وضغیت درس است
    protected $lessonStatus;

    //اطلاعات کاربر
    public $userData;

    //حداقل واحد مجاز برای انتخاب
    public $minUnits;

    //حداکثر واحد مجاز برای انتخاب
    public $maxUnits;

    //این متغیر برای ذخیره  کلاس ها است
    public $takeListen;

    //این آرایه برای ذخیره ساعت کلاس ها است
    public $classSchedules = [];

    // این متغیر برای ذخیره دروس اراعه شده انتخاب شده است
    public $lessons;

    // این متغیر برای ذخیره دروس انتخاب شده است تا از اسم تکراری در لیست دروس جلو گیری شود
    public $uniqueLessons;

    //این متغیر برای ذخیره تعداد کل واحدهای انتخاب شده است
    public $totalUnits;

    //این متغیر برای ذخیره حزینه کل دروس است
    public $totalMoney;

    //این متغیر برای نمایش لیست دروس انتخاب شده است
    public $showLessonList = false;

    //این متغیر برای نمایش جزئیات دروس انتخاب شده است
    public $showLessonDetails = false;

    //این متغیر برای ذخیره اسم درس از لیست دروس انتخاب شده است
    public $lessonName = '';

    //این متغیر برای ذخیره دروس است
    public $selectedLesson = [];

    //این آرایه برای ذخیره دروس برای نمایش جزئیات انتخاب شده است
    public $lessonSelected;

    //این متد برای سوار کردن داده ها دیتا در متغیر هاست
    public function mount($data)
    {
        // تزریق سرویس‌ها
        $this->accountService = app(AccountService::class);
        $this->lessonStatus = app(LessonStatus::class);

        // مقداردهی داده‌های اولیه
        $this->minUnits = $data['minMax']->min_unit;
        $this->maxUnits = $data['minMax']->max_unit;
        $this->lessons = $data['lessonOffered'];
        $this->takeListen = $data['takeListen'];
        $this->userData = $data['userData'];
        $this->UniqueLessons();
    }

    //این متد دروس تکراری را حذف می‌کند و فقط یک نمونه از هر درس را نگه می‌دارد
    protected function UniqueLessons()
    {
        $this->uniqueLessons = $this->lessons->unique('lesten_name');
    }

    //این متد برای نمایش جزئیات دروس انتخاب شده است
    public function showLessonDetails($lessonName)
    {
        $this->showLessonList = false;
        $this->showLessonDetails = true;
        $this->lessonName = $lessonName;
        $this->lessonSelected = $this->lessons->where('lesten_name', $lessonName)->all();
    }

    //این متد برای انتخاب درس است
    public function takeLesson($lessonId)
    {
        //درس را از لیست دروس انتخاب کنیم
        $lesson = $this->lessons->firstWhere('lesten_id', $lessonId);

        //محاسبه تعداد کل واحدهای انتخاب شده
        $newTotalUnits = $this->totalUnits + $lesson->unit_count;

        //دیکدینگ زمان
        $schedule = json_decode($lesson->class_schedule);

        // استخراج روزها و زمان شروع و پایان
        $days = implode('، ', $schedule->days);
        $timeRange = "{$schedule->time->start} - {$schedule->time->end}";


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

        if (in_array($days . ' ' . $timeRange, $this->classSchedules)) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => "درس در زمان{$days} {$timeRange} انتخاب شده است."
            ]);
            return;
        }


        //درس را به لیست دروس انتخاب شده اضافه کنیم
        $this->selectedLessons[] = $lessonId;

        //محاسبه تعداد کل واحدهای انتخاب شده
        $this->calculateTotalUnits();

        //محاسبه حزینه کل دروس
        $this->calculateTotalMoney();

        //محاسبه زمان کلاس ها
        $this->calculateTotalTime($lessonId, $days, $timeRange);

        $lesson->registered_count++;

        $this->lessonStatus->update([
            'lesson_id' => $lessonId,
            'student_name' => $this->userData->name,
            'master_name' => $lesson->lesten_master,
        ]);

        //جزئیات درس را مخفی کنیم
        $this->showLessonDetails = false;
    }

    //این متد برای حذف درس از لیست دروس انتخاب شده است
    public function removeLesson($lessonId)
    {
        //حذف درس از لیست دروس انتخاب شده
        $this->selectedLessons[] = array_diff($this->selectedLessons, [$lessonId]);

        //محاسبه تعداد کل واحدهای انتخاب شده
        $this->calculateTotalUnits();

        //محاسبه حزینه کل دروس
        $this->calculateTotalMoney();

        //محاسبه زمان کلاس ها
        $this->classSchedules = array_filter($this->classSchedules, function ($schedule) use ($lessonId) {
            return !str_starts_with($schedule, "{$lessonId} "); // آیتم‌هایی که با ایدی موردنظر شروع می‌شوند حذف می‌شوند
        });

        $this->lessons->firstWhere('lesten_id', $lessonId)->registered_count--;
    }

    //محاسبه تعداد کل واحدهای انتخاب شده
    protected function calculateTotalUnits()
    {
        //محاسبه تعداد کل واحدهای انتخاب شده
        $this->totalUnits = $this->lessons->whereIn('lesten_id', $this->selectedLessons)->sum('unit_count');
    }

    //محاسبه حزینه کل دروس
    protected function calculateTotalMoney()
    {
        $this->totalMoney = $this->lessons->whereIn('lesten_id', $this->selectedLessons)->sum('lesten_price');
    }

    //محاسبه زمان کلاس ها
    protected function calculateTotalTime($lessonId, $days, $timeRange)
    {
        $this->classSchedules[] = "{$lessonId} {$days} {$timeRange}";
    }

    //این متد برای ثبت دروس انتخاب شده است
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

        try {
            // دریافت وضعیت کاربر
            $takeListen = $this->takeListen;

            // تبدیل آرایه درس‌های انتخاب شده به JSON
            $selectedLessonsJson = json_encode($this->selectedLessons);

            // به‌روزرسانی ستون take_listen
            $takeListen->update([
                'take_listen' => $selectedLessonsJson
            ]);

            //به‌روزرسانی بدهی کاربر
            $this->accountService->UbdateDebt($this->totalMoney);

            $this->dispatch('show-message', [
                'type' => 'success',
                'message' => 'دروس با موفقیت ثبت شدند.'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-message', [
                'type' => 'error',
                'message' => 'خطا در ثبت دروس: ' . $e->getMessage()
            ]);
        }
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
