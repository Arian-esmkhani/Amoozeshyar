<?php

namespace App\Livewire; // تعریف فضای نام برای کامپوننت‌های Livewire

use Livewire\Component; // استفاده از کلاس Component از Livewire
use App\Services\AccountService; // استفاده از سرویس AccountService
use App\Models\LessonStatus; // استفاده از مدل LessonStatus
use App\Models\LessonOffered; // استفاده از مدل LessonOffered
use Livewire\Attributes\On; // استفاده از ویژگی‌های Livewire
use Illuminate\Support\Facades\Auth; // استفاده از فاساد Auth برای مدیریت احراز هویت
use Illuminate\Support\Facades\Log; // استفاده از فاساد Log برای ثبت رویدادها

// کلاس ایجاد کامپوننت انتخاب واحد
class EntekhabVahed extends Component
{
    // این متغیر برای سرویس کار با بخش مالی کاربر است
    protected $accountService;

    // این برای وضعیت درس است
    protected $lessonStatus;

    // اطلاعات کاربر
    public $userData;

    // حداقل واحد مجاز برای انتخاب
    public $minUnits;

    // حداکثر واحد مجاز برای انتخاب
    public $maxUnits;

    // این متغیر برای ذخیره کلاس‌ها است
    public $userStatus;

    // این آرایه برای ذخیره ساعت کلاس‌ها است
    public $classSchedules = [];

    // این متغیر برای ذخیره دروس ارائه شده انتخاب شده است
    public $lessons;

    // این متغیر برای ذخیره دروس انتخاب شده است تا از اسم تکراری در لیست دروس جلوگیری شود
    public $uniqueLessons;

    // این متغیر برای ذخیره تعداد کل واحدهای انتخاب شده است
    public $totalUnits;

    // این متغیر برای ذخیره هزینه کل دروس است
    public $totalMoney;

    // این متغیر برای نمایش لیست دروس انتخاب شده است
    public $showLessonList = false;

    // این متغیر برای نمایش جزئیات دروس انتخاب شده است
    public $showLessonDetails = false;

    // این متغیر برای ذخیره اسم درس از لیست دروس انتخاب شده است
    public $lessonName = '';

    // این متغیر برای ذخیره دروس است
    public $selectedLesson = [];

    // این آرایه برای ذخیره دروس برای نمایش جزئیات انتخاب شده است
    public $lessonSelected;

    // این متد برای سوار کردن داده‌ها دیتا در متغیرهاست
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

        if ($this->userData) {
            $this->selectedLesson = $this->lessonStatus
                ->where('student_name', $this->userData->name)
                ->pluck('lesson_id')
                ->toArray();

            $this->calculateTotalUnits();
            $this->calculateTotalMoney();
            $this->populateInitialSchedules();
        }

        // وضعیت کاربر
        $this->userStatus = $data['userStatus'];

        $this->UniqueLessons();
    }


    protected function populateInitialSchedules()
    {
        // لیست زمان‌بندی کلاس‌ها را خالی می‌کنیم
        $this->classSchedules = [];

        // بر روی تمامی درس‌های انتخاب‌شده حلقه می‌زنیم
        foreach ($this->selectedLesson as $lessonId) {
            // یافتن درس مرتبط با شناسه مشخص‌شده
            $lesson = $this->lessons->firstWhere('id', $lessonId);

            // بررسی می‌کنیم که آیا درس وجود دارد و برنامه کلاس آن تنظیم شده است
            if ($lesson && isset($lesson->class_schedule)) {
                try {
                    // برنامه کلاس را از فرمت JSON به یک شیء تبدیل می‌کنیم
                    $schedule = json_decode($lesson->class_schedule, false, 512, JSON_THROW_ON_ERROR);

                    // بررسی می‌کنیم که ساختار داده‌های برنامه کلاس صحیح باشد
                    if (isset($schedule->days) && isset($schedule->time->start) && isset($schedule->time->end)) {
                        // ترکیب روزها به یک رشته برای نمایش خواناتر
                        $days = implode('، ', (array)$schedule->days);

                        // ایجاد محدوده زمانی (از ساعت شروع تا ساعت پایان)
                        $timeRange = "{$schedule->time->start} - {$schedule->time->end}";

                        // محاسبه زمان کل و اضافه کردن آن به لیست زمان‌بندی‌ها
                        $this->calculateTotalTime($lessonId, $days, $timeRange);
                    }
                } catch (\JsonException $e) {
                    // اگر خطایی در تجزیه JSON رخ دهد، می‌توانیم آن را مدیریت کنیم یا ثبت کنیم
                    // log($e->getMessage());
                }
            }
        }
    }

    // این متد دروس تکراری را حذف می‌کند و فقط یک نمونه از هر درس را نگه می‌دارد
    protected function UniqueLessons()
    {
        $this->uniqueLessons = $this->lessons->unique('lesten_name');
    }

    // این متد برای نمایش جزئیات دروس انتخاب شده است
    #[On('show-lesson-details')]
    public function showLessonDetails($lessonName)
    {
        $this->showLessonList = false;
        $this->showLessonDetails = true;
        $this->lessonName = $lessonName;
        $this->lessonSelected = $this->lessons->where('lesten_name', $lessonName)->all();
    }

    // این متد برای انتخاب درس است
    public function actionLesson($lessonId)
    {
        // اگر آرایه خالی باشد، آن را مقداردهی اولیه می‌کنیم
        if (is_null($this->lessonStatus)) {
            $this->lessonStatus = app(LessonStatus::class);
        }

        // یافتن درس مرتبط با شناسه مشخص‌شده
        $lesson = $this->lessons->firstWhere('lesten_id', $lessonId);

        // اگر درس در آرایه انتخاب شده باشد، آن را حذف می‌کنیم
        if (in_array($lessonId, $this->selectedLesson)) {

            $this->selectedLesson = array_diff($this->selectedLesson, [$lessonId]);
            //آرایه دوباره مرتب‌ می‌شود (شماره‌های ایندکس درست می‌شوند)
            $this->selectedLesson = array_values($this->selectedLesson);


            $this->calculateTotalUnits();
            $this->calculateTotalMoney();

            // محاسبه زمان کلاس‌ها
            $this->classSchedules = array_filter($this->classSchedules, function ($schedule) use ($lessonId) {
                return !str_starts_with($schedule, "{$lessonId} ");
            });

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


            if ($lesson) {
                $lesson->registered_count = max(0, $lesson->registered_count - 1);
                LessonOffered::where('lesten_id', $lessonId)->where('registered_count', '>', 0)->decrement('registered_count');
            }
        } else {
            // --- افزودن درس ---
            if (!$lesson) {
                session()->flash('message', "درس مورد نظر یافت نشد.");
                session()->flash('type', 'error');
                return;
            }

            // محاسبه تعداد کل واحدهای انتخاب شده
            $newTotalUnits = $this->totalUnits + $lesson->unit_count;

            // دیکدینگ زمان
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

            // بررسی اگر تعداد واحدهای انتخاب شده از حداکثر واحد مجاز بیشتر باشد
            if ($newTotalUnits > $this->maxUnits) {
                session()->flash('message', "با انتخاب این درس از سقف مجاز واحد ({$this->maxUnits}) بیشتر می‌شود.");
                session()->flash('type', 'error');
                return;
            }

            // بررسی اگر ظرفیت کلاس تکمیل شده باشد
            if ($lesson->capacity <= $lesson->registered_count) {
                session()->flash('message', "ظرفیت این درس تکمیل شده است.");
                session()->flash('type', 'error');
                return;
            }

            // درس را به لیست دروس انتخاب شده اضافه کنیم
            $this->selectedLesson[] = $lessonId;
            $this->selectedLesson = array_values($this->selectedLesson);

            // محاسبه تعداد کل واحدهای انتخاب شده
            $this->calculateTotalUnits();

            // محاسبه هزینه کل دروس
            $this->calculateTotalMoney();

            // محاسبه زمان کلاس‌ها
            $this->calculateTotalTime($lessonId, $days, $timeRange);

            // افزایش registered_count در حافظه
            $lesson->registered_count++;
            LessonOffered::where('lesten_id', $lessonId)->increment('registered_count');

            // ثبت رکورد دروس
            $this->lessonStatus->create([
                'lesson_id' => $lessonId,
                'lesson_name' => $lesson->lesten_name,
                'student_name' => $this->userData->name,
                'master_name' => $lesson->lesten_master,
            ]);

            // جزئیات درس را مخفی کنیم
            $this->showLessonDetails = false;
        }
    }

    // محاسبه تعداد کل واحدهای انتخاب شده
    protected function calculateTotalUnits()
    {
        $this->totalUnits = $this->lessons->whereIn('lesten_id', $this->selectedLesson)->sum('unit_count');
    }

    // محاسبه هزینه کل دروس
    protected function calculateTotalMoney()
    {
        $this->totalMoney = $this->lessons->whereIn('lesten_id', $this->selectedLesson)->sum('lesten_price');
    }

    // محاسبه زمان کلاس‌ها
    protected function calculateTotalTime($lessonId, $days, $timeRange)
    {
        $this->classSchedules[] = "{$lessonId} {$days} {$timeRange}";
    }

    // این متد برای ثبت دروس انتخاب شده است
    public function submit()
    {
        // بررسی حداقل واحد
        if ($this->totalUnits < $this->minUnits) {
            session()->flash('message', "حداقل {$this->minUnits} واحد باید انتخاب کنید.");
            session()->flash('type', 'error');
            return;
        }

        // بررسی حداکثر واحد
        if ($this->totalUnits > $this->maxUnits) {
            session()->flash('message', "حداکثر {$this->maxUnits} واحد می‌توانید انتخاب کنید.");
            session()->flash('type', 'error');
            return;
        }

        try {
            // اگر سرویس خالی باشد، آن را مقداردهی اولیه می‌کنیم
            if (is_null($this->accountService)) {
                $this->accountService = app(AccountService::class);
            }

            $userStatus = Auth::user()->userStatus()->first();

            if (!$userStatus) {
                Log::warning("EntekhabVahed: UserStatus record not found for user {$this->userData->name} during submission.");
                return;
            }

            // تبدیل آرایه درس‌های انتخاب شده به JSON
            $selectedLessonsJson = json_encode(array_values($this->selectedLesson));

            // به‌روزرسانی ستون take_listen در userStatus
            $userStatus->update([
                'take_listen' => $selectedLessonsJson
            ]);

            // به‌روزرسانی بدهی کاربر
            $this->accountService->ubdateDebt($this->totalMoney);

            session()->flash('message', 'دروس با موفقیت ثبت شدند.');
            session()->flash('type', 'success');
        } catch (\Exception $e) {
            session()->flash('message', 'خطا در ثبت دروس: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }

    // رندر کردن ویو
    public function render()
    {
        return view('livewire.entekhab-vahed');
    }
}
