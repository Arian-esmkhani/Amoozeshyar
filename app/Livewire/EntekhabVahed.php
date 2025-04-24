<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\AccountService;
use App\Models\LessonStatus;
use App\Models\LessonOffered;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

//کلاس ایجاد کامپننت انتخاب واحد
class EntekhabVahed extends Component
{
    //این متغیر برای سرویس کار با بخش مالی کار بر است
    protected $accountService;

    //این برای وضغیت درس است
    protected $lessonStatus;

    //اطلاعات کاربر
    public $userData;

    //حداقل واحد مجاز برای انتخاب
    public $minUnits;

    //حداکثر واحد مجاز برای انتخاب
    public $maxUnits;

    //این متغیر برای ذخیره  کلاس ها است
    public $userStatus;

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
        $this->userData = $data['userData'];
        // Note: $data['userStatus'] is assigned below after loading selected lessons

        // Load previously selected lessons for the current user
        // Ensure userData is available before querying
        if ($this->userData) {
            $this->selectedLesson = $this->lessonStatus
                ->where('student_name', $this->userData->name) // Consider using user ID if available
                ->pluck('lesson_id')
                ->toArray();

            // Calculate initial totals and schedules based on loaded lessons
            $this->calculateTotalUnits();
            $this->calculateTotalMoney();
            $this->populateInitialSchedules();
        }

        // This was originally passed in $data, ensure it's still relevant or loaded differently if needed
        $this->userStatus = $data['userStatus'];

        $this->UniqueLessons();
    }

    // Helper method to populate initial class schedules based on $selectedLesson
    protected function populateInitialSchedules()
    {
        $this->classSchedules = [];
        foreach ($this->selectedLesson as $lessonId) {
            $lesson = $this->lessons->firstWhere('id', $lessonId);
            if ($lesson && isset($lesson->class_schedule)) {
                try {
                    $schedule = json_decode($lesson->class_schedule, false, 512, JSON_THROW_ON_ERROR);
                    if (isset($schedule->days) && isset($schedule->time->start) && isset($schedule->time->end)) {
                        $days = implode('، ', (array)$schedule->days);
                        $timeRange = "{$schedule->time->start} - {$schedule->time->end}";
                        $this->calculateTotalTime($lessonId, $days, $timeRange); // Use existing method
                    }
                } catch (\JsonException $e) {
                    // Handle or log error if necessary
                }
            }
        }
    }

    //این متد دروس تکراری را حذف می‌کند و فقط یک نمونه از هر درس را نگه می‌دارد
    protected function UniqueLessons()
    {
        $this->uniqueLessons = $this->lessons->unique('lesten_name');
    }

    //این متد برای نمایش جزئیات دروس انتخاب شده است
    #[On('show-lesson-details')]
    public function showLessonDetails($lessonName)
    {
        $this->showLessonList = false;
        $this->showLessonDetails = true;
        $this->lessonName = $lessonName;
        $this->lessonSelected = $this->lessons->where('lesten_name', $lessonName)->all();
    }

    //این متد برای انتخاب درس است
    public function actionLesson($lessonId)
    {
        // Ensure lessonStatus is initialized (Workaround for potential state loss)
        if (is_null($this->lessonStatus)) {
            $this->lessonStatus = app(LessonStatus::class);
        }

        // Use lesten_id for consistency, assuming this is the correct identifier stored
        $lesson = $this->lessons->firstWhere('lesten_id', $lessonId);

        if (in_array($lessonId, $this->selectedLesson)) {
            // --- REMOVING LESSON ---
            $this->selectedLesson = array_diff($this->selectedLesson, [$lessonId]);
            $this->selectedLesson = array_values($this->selectedLesson); // Re-index after removal

            // Recalculate totals after removing lesson
            $this->calculateTotalUnits();
            $this->calculateTotalMoney();

            //محاسبه زمان کلاس ها
            $this->classSchedules = array_filter($this->classSchedules, function ($schedule) use ($lessonId) {
                return !str_starts_with($schedule, "{$lessonId} ");
            });

            // <<< 2b. Update LessonStatus status before soft deleting >>>
            $statusRecord = $this->lessonStatus
                ->where('lesson_id', $lessonId)
                ->where('student_name', $this->userData->name)
                ->first();

            if ($statusRecord) {
                $statusRecord->lesson_status = 'حذف'; // Set status
                $statusRecord->save();          // Save change
                $statusRecord->delete();         // Soft delete
            } else {
                Log::warning("EntekhabVahed: LessonStatus record not found for lesson_id {$lessonId} / student {$this->userData->name} during removal.");
            }

            // Decrement registered count in memory
            if ($lesson) {
                $lesson->registered_count = max(0, $lesson->registered_count - 1);
                // <<< 1b. Persist decrement to DB >>>
                LessonOffered::where('lesten_id', $lessonId)->where('registered_count', '>', 0)->decrement('registered_count');
            }
        } else {
            // --- ADDING LESSON ---
            if (!$lesson) {
                session()->flash('message', "درس مورد نظر یافت نشد.");
                session()->flash('type', 'error');
                return;
            }

            //محاسبه تعداد کل واحدهای انتخاب شده
            $newTotalUnits = $this->totalUnits + $lesson->unit_count;

            //دیکدینگ زمان
            $schedule = json_decode($lesson->class_schedule);

            // استخراج روزها و زمان شروع و پایان
            $days = '';
            $timeRange = '';
            if ($schedule && isset($schedule->days) && isset($schedule->time->start) && isset($schedule->time->end)) {
                $days = implode('، ', (array)$schedule->days);
                $timeRange = "{$schedule->time->start} - {$schedule->time->end}";
            }
            $scheduleStringToCheck = $days . ' ' . $timeRange;
            if (!empty(trim($scheduleStringToCheck))) {
                foreach ($this->classSchedules as $existingSchedule) {
                    $existingDayTime = substr($existingSchedule, strpos($existingSchedule, ' ') + 1);
                    if ($existingDayTime === $scheduleStringToCheck) {
                        session()->flash('message', "تداخل زمانی با درس دیگری در روز {$days} ساعت {$timeRange} وجود دارد.");
                        session()->flash('type', 'error');
                        return;
                    }
                }
            }

            //بررسی اگر تعداد واحدهای انتخاب شده از حداکثر واحد مجاز بیشتر باشد
            if ($newTotalUnits > $this->maxUnits) {
                session()->flash('message', "با انتخاب این درس از سقف مجاز واحد ({$this->maxUnits}) بیشتر می‌شود.");
                session()->flash('type', 'error');
                return;
            }

            //بررسی اگر ظرفیت کلاس تکمیل شده باشد
            if ($lesson->capacity <= $lesson->registered_count) {
                session()->flash('message', "ظرفیت این درس تکمیل شده است.");
                session()->flash('type', 'error');
                return;
            }

            //درس را به لیست دروس انتخاب شده اضافه کنیم
            $this->selectedLesson[] = $lessonId;
            $this->selectedLesson = array_values($this->selectedLesson); // Ensure keys are sequential after adding

            //محاسبه تعداد کل واحدهای انتخاب شده
            $this->calculateTotalUnits();

            //محاسبه حزینه کل دروس
            $this->calculateTotalMoney();

            //محاسبه زمان کلاس ها
            $this->calculateTotalTime($lessonId, $days, $timeRange);

            // Increment registered_count in memory
            $lesson->registered_count++;
            // <<< 1a. Persist increment to DB >>>
            LessonOffered::where('lesten_id', $lessonId)->increment('registered_count');

            // Create LessonStatus record
            $this->lessonStatus->create([
                'lesson_id' => $lessonId,
                'lesson_name' => $lesson->lesten_name,
                'student_name' => $this->userData->name,
                'master_name' => $lesson->lesten_master,
            ]);

            //جزئیات درس را مخفی کنیم
            $this->showLessonDetails = false;
        }
    }

    //محاسبه تعداد کل واحدهای انتخاب شده
    protected function calculateTotalUnits()
    {
        //محاسبه تعداد کل واحدهای انتخاب شده
        $this->totalUnits = $this->lessons->whereIn('lesten_id', $this->selectedLesson)->sum('unit_count');
    }

    //محاسبه حزینه کل دروس
    protected function calculateTotalMoney()
    {
        $this->totalMoney = $this->lessons->whereIn('lesten_id', $this->selectedLesson)->sum('lesten_price');
    }

    //محاسبه زمان کلاس ها
    protected function calculateTotalTime($lessonId, $days, $timeRange)
    {
        $this->classSchedules[] = "{$lessonId} {$days} {$timeRange}";
    }

    //این متد برای ثبت دروس انتخاب شده است
    public function submit()
    {
        //  بررسی حداقل واحد
        if ($this->totalUnits < $this->minUnits) {
            session()->flash('message', "حداقل {$this->minUnits} واحد باید انتخاب کنید.");
            session()->flash('type', 'error');
            return;
        }

        //  بررسی حداکثر واحد
        if ($this->totalUnits > $this->maxUnits) {
            session()->flash('message', "حداکثر {$this->maxUnits} واحد می‌توانید انتخاب کنید.");
            session()->flash('type', 'error');
            return;
        }

        try {
            // Ensure services are initialized (Workaround for potential state loss)
            if (is_null($this->accountService)) {
                $this->accountService = app(AccountService::class);
            }

            $userStatus = Auth::user()->userStatus()->first();
            if (!$userStatus) {
                session()->flash('message', 'وضعیت کاربر یافت نشد.');
                session()->flash('type', 'error');
                return;
            }

            //  تبدیل آرایه درس‌های انتخاب شده به JSON (با تضمین اینکه آرایه باشد)
            $selectedLessonsJson = json_encode(array_values($this->selectedLesson));

            //  به‌روزرسانی ستون take_listen در userStatus
            $userStatus->update([
                'take_listen' => $selectedLessonsJson
            ]);

            //  به‌روزرسانی بدهی کاربر
            $this->accountService->ubdateDebt($this->totalMoney);

            session()->flash('message', 'دروس با موفقیت ثبت شدند.');
            session()->flash('type', 'success');
        } catch (\Exception $e) {
            session()->flash('message', 'خطا در ثبت دروس: ' . $e->getMessage());
            session()->flash('type', 'error');
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
