<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\AccountService;
use App\Models\LessonStatus;
use App\Models\UserStatus;
use App\Models\LessonOffered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

//کلاس ایجاد کامپننت حذف و اضافه
class HazfEzafe extends Component
{
    //این متغیر برای سرویس کار با بخش مالی کار بر است
    protected $accountService;

    //این  برای وضغیت درس است
    protected $lessonStatus;

    //اطلاعات کاربر
    public $userData;

    //حداقل واحد مجاز برای انتخاب
    public $minUnits;

    //حداکثر واحد مجاز برای انتخاب
    public $maxUnits;

    //این متغیر برای ذخیره ID کلاس های انتخاب شده است
    public $takeListen = [];

    //این آرایه برای ذخیره ساعت کلاس های انتخاب شده (برای بررسی تداخل)
    public $classSchedules = [];

    // این متغیر برای ذخیره تمام دروس اراعه شده است
    public $lessons;

    // این متغیر برای ذخیره دروس انتخاب شده توسط کاربر است (آبجکت‌های LessonOffered)
    public $selectedLessons;

    // این متغیر برای ذخیره دروس اراعه شده با نام غیر تکراری است
    public $uniqueLessons;

    //این متغیر برای ذخیره تعداد کل واحدهای انتخاب شده است
    public $totalUnits = 0;

    //این متغیر برای نمایش لیست دروس انتخاب شده است
    public $showLessonList = false;

    //این متغیر برای نمایش جزئیات دروس انتخاب شده است
    public $showLessonDetails = false;

    //این متغیر برای ذخیره اسم درس از لیست دروس انتخاب شده است
    public $lessonName = '';

    //این آرایه برای ذخیره دروس برای نمایش جزئیات انتخاب شده است
    public $lessonSelected;

    /**
     * کلید منحصر به فرد سشن برای هر کاربر را برمی‌گرداند
     */
    protected function getSessionKey(): string
    {
        return 'hazf_ezafe_state_' . Auth::id();
    }

    /**
     * لیست فعلی ID درس‌های گرفته شده را در سشن ذخیره می‌کند
     */
    protected function updateSessionState(): void
    {
        Session::put($this->getSessionKey(), $this->takeListen);
    }

    //این متد برای سوار کردن داده ها دیتا در متغیر هاست
    public function mount($data)
    {
        // تزریق سرویس‌ها
        $this->accountService = app(AccountService::class);
        $this->lessonStatus = app(LessonStatus::class);

        // مقداردهی داده‌های اولیه از کنترلر
        $this->minUnits = $data['minMax']->min_unit ?? 12;
        $this->maxUnits = $data['minMax']->max_unit ?? 20;
        $this->userData = $data['userData'];
        $this->lessons = $data['lessonOffered'] ?? collect(); // همه دروس قابل افزودن

        // گرفتن ID های ذخیره شده در دیتابیس به عنوان مقدار پیش‌فرض
        $savedLessonIds = ($data['selectedLessons'] ?? collect())->pluck('lesten_id')->toArray();

        // خواندن ID های دروس گرفته شده از سشن، اگر نبود از مقدار دیتابیس استفاده کن
        $this->takeListen = Session::get($this->getSessionKey(), $savedLessonIds);

        // <<< بازسازی selectedLessons بر اساس takeListen بارگذاری شده از سشن >>>
        $allLessonsCollection = ($this->lessons instanceof Collection) ? $this->lessons : collect($this->lessons);
        // همچنین دروس اولیه (از دیتابیس) را به لیست کلی اضافه می‌کنیم تا اگر درسی حذف شده بود و الان در سشن نیست،
        // ولی از دیتابیس آمده، در بازسازی لحاظ شود.
        $initialSelectedLessons = $data['selectedLessons'] ?? collect();
        $combinedLessonsForLookup = $allLessonsCollection->merge($initialSelectedLessons)->unique('lesten_id'); // اطمینان از یکتایی

        $this->selectedLessons = $combinedLessonsForLookup->whereIn('lesten_id', $this->takeListen)->values();
        // <<< پایان بازسازی >>>

        // محاسبه وضعیت اولیه (واحدها و ...) بر اساس selectedLessons بازسازی شده
        $this->calculateInitialState();
        $this->UniqueLessons(); // برای نمایش لیست دروس قابل افزودن
    }

    //محاسبه وضعیت اولیه (واحدها و زمانبندی) بر اساس دروس از قبل انتخاب شده
    protected function calculateInitialState()
    {
        $this->totalUnits = 0;
        $this->classSchedules = [];

        // <<< محاسبه بر اساس selectedLessons واقعی >>>
        foreach ($this->selectedLessons as $lesson) {
            $this->totalUnits += $lesson->unit_count;
            // Decode schedule and add to classSchedules for conflict checking
            if (!empty($lesson->class_schedule)) {
                $schedule = json_decode($lesson->class_schedule);
                if ($schedule && isset($schedule->days) && isset($schedule->time->start) && isset($schedule->time->end)) {
                    $days = implode('، ', $schedule->days);
                    $timeRange = "{$schedule->time->start} - {$schedule->time->end}";
                    // بقیه همینطور
                    $this->classSchedules[] = "{$lesson->lesten_id} {$days} {$timeRange}";
                }
            }
        }
    }

    //این متد دروس تکراری (قابل افزودن) را حذف می‌کند
    protected function UniqueLessons()
    {
        // <<< باید روی this->lessons (قابل افزودن) کار کند >>>
        if ($this->lessons instanceof Collection) {
            $this->uniqueLessons = $this->lessons->unique('lesten_name');
        } else {
            $this->uniqueLessons = collect($this->lessons)->unique('lesten_name');
        }
    }

    //این متد برای نمایش جزئیات دروس انتخاب شده است
    #[On('show-lesson-details')]
    public function showLessonDetails($lessonName)
    {
        $this->showLessonList = false;
        $this->showLessonDetails = true;
        $this->lessonName = $lessonName;
        //یافتن درس مرتبط با اسم درس
        $lessonsCollection = ($this->lessons instanceof Collection) ? $this->lessons : collect($this->lessons);
        //فیلتر کردن دروس مرتبط با اسم درس
        $filteredLessons = $lessonsCollection->filter(function ($lesson) use ($lessonName) {
            return $lesson->lesten_name === $lessonName;
        });
        $this->lessonSelected = $filteredLessons->values()->all(); // به صورت آرایه برگرداندن
    }

    //این متد برای انتخاب درس است
    public function actionLesson($lessonId)
    {
        // اگر سرویس خالی باشد، آن را مقداردهی اولیه می‌کنیم
        if (is_null($this->accountService)) {
            $this->accountService = app(AccountService::class);
        }
        if (is_null($this->lessonStatus)) {
            $this->lessonStatus = app(LessonStatus::class);
        }

        //درس را از لیست دروس انتخاب کنیم
        $lesson = $this->lessons->firstWhere('lesten_id', $lessonId);

        if (!$lesson) {
            session()->flash('message', "درس مورد نظر یافت نشد.");
            session()->flash('type', 'error');
            return;
        }

        //محاسبه تعداد کل واحدهای انتخاب شده
        $newTotalUnits = $this->totalUnits + $lesson->unit_count;

        //دیکدینگ زمان
        $scheduleData = json_decode($lesson->class_schedule);
        $days = '';
        $timeRange = '';
        if ($scheduleData && isset($scheduleData->days) && isset($scheduleData->time->start) && isset($scheduleData->time->end)) {
            $days = implode('، ', $scheduleData->days);
            $timeRange = "{$scheduleData->time->start} - {$scheduleData->time->end}";
        }

        //بررسی اگر تعداد واحدهای انتخاب شده از حداکثر واحد مجاز بیشتر باشد
        if ($newTotalUnits > $this->maxUnits) {
            session()->flash('message', "با انتخاب این درس، سقف مجاز واحد ({$this->maxUnits}) رعایت نمی‌شود.");
            session()->flash('type', 'error');
            return;
        }

        //بررسی اگر ظرفیت کلاس تکمیل شده باشد
        if ($lesson->capacity <= $lesson->registered_count) {
            session()->flash('message', "ظرفیت این درس تکمیل شده است.");
            session()->flash('type', 'error');
            return;
        }

        // یافتن تداخل زمانی
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

        //درس را به لیست دروس انتخاب شده اضافه کنیم
        if (!in_array($lessonId, $this->takeListen)) {
            $this->takeListen[] = $lessonId;
            $this->selectedLessons->push($lesson);

            // محاسبه تعداد کل واحدهای انتخاب شده
            $this->calculateTotalUnits();

            // محاسبه زمان کلاس ها
            $this->calculateTotalTime($lessonId, $days, $timeRange);

            // <<< ذخیره وضعیت موقت در سشن >>>
            $this->updateSessionState();

            // افزایش registered_count در دیتابیس
            LessonOffered::where('lesten_id', $lessonId)->increment('registered_count');

            // به‌روزرسانی اعتبار حساب و سیاهه‌ی درس
            $this->accountService->userAdd($lesson->lesten_price);

            $this->lessonStatus->create([
                'lesson_id' => $lessonId,
                'lesson_name' => $lesson->lesten_name,
                'student_name' => $this->userData->name,
                'master_name' => $lesson->lesten_master,
            ]);
        }

        //جزئیات درس را مخفی کنیم
        $this->showLessonDetails = false;
    }

    //محاسبه تعداد کل واحدهای انتخاب شده
    protected function calculateTotalUnits()
    {
        $this->totalUnits = $this->selectedLessons->sum('unit_count');
    }

    //محاسبه زمان کلاس ها
    protected function calculateTotalTime($lessonId, $days, $timeRange)
    {
        // ایجاد رشته زمانی جدید
        $newScheduleString = "{$lessonId} {$days} {$timeRange}";
        if (!in_array($newScheduleString, $this->classSchedules)) {
            $this->classSchedules[] = $newScheduleString;
        }
    }

    //این متد برای ثبت نهایی تغییرات (حذف و اضافه) است
    public function submit()
    {
        if ($this->totalUnits < $this->minUnits) {
            session()->flash('message', "حداقل {$this->minUnits} واحد باید انتخاب کنید. تعداد واحدهای فعلی: {$this->totalUnits}");
            session()->flash('type', 'error');
            return;
        }

        if ($this->totalUnits > $this->maxUnits) {
            session()->flash('message', "حداکثر {$this->maxUnits} واحد می‌توانید انتخاب کنید. تعداد واحدهای فعلی: {$this->totalUnits}");
            session()->flash('type', 'error');
            return;
        }

        try {
            $user = Auth::user();
            if (!$user) {
                throw new \Exception("کاربر شناسایی نشد.");
            }

            // دریافت وضعیت کاربر
            $userStatus = UserStatus::where('user_id', $user->id)->first();
            if (!$userStatus) {
                throw new \Exception("وضعیت دانشجو یافت نشد.");
            }

            // تبدیل آرایه ID درس‌های انتخاب شده به JSON
            $selectedLessonsJson = json_encode(array_values($this->takeListen));

            // به‌روزرسانی ستون take_listen در دیتابیس
            $userStatus->update([
                'take_listen' => $selectedLessonsJson
            ]);

            // <<< پاک کردن وضعیت موقت از سشن >>>
            Session::forget($this->getSessionKey());

            // ارسال پیام موفقیت
            session()->flash('message', 'تغییرات حذف و اضافه با موفقیت ثبت شدند.');
            session()->flash('type', 'success');
        } catch (\Exception $e) {
            report($e);
            session()->flash('message', 'خطا در ثبت تغییرات: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }

    //از این جا به بعد برای حذف کردن در حذف و اضافه هستش
    public function hazf($lessonId)
    {
        // اگر سرویس خالی باشد، آن را مقداردهی اولیه می‌کنیم
        if (is_null($this->accountService)) {
            $this->accountService = app(AccountService::class);
        }
        if (is_null($this->lessonStatus)) {
            $this->lessonStatus = app(LessonStatus::class);
        }

        // درس را از لیست دروس انتخاب کنیم (از لیست کل دروس موجود)
        $lesson = $this->lessons->firstWhere('lesten_id', $lessonId);

        if (!$lesson) {
            session()->flash('message', 'درس مورد نظر یافت نشد.');
            session()->flash('type', 'error');
            return;
        }

        // <<< بررسی حداقل واحد قبل از حذف >>>
        $newTotalUnits = $this->totalUnits - $lesson->unit_count;
        if ($newTotalUnits < $this->minUnits) {
            session()->flash('message', "با حذف این درس، حداقل واحد مجاز ({$this->minUnits}) رعایت نمی‌شود.");
            session()->flash('type', 'error');
            return; // << جلوگیری از ادامه حذف
        }
        // <<< پایان بررسی حداقل واحد >>>

        $initialTakeListenCount = count($this->takeListen); // برای اطمینان از اینکه واقعا حذف شده

        // حذف ID درس از آرایه takeListen
        $this->takeListen = array_diff($this->takeListen, [$lessonId]);

        // فقط اگر درسی واقعا از لیست حذف شد، ادامه بده
        if (count($this->takeListen) < $initialTakeListenCount) {
            // حذف درس از لیست دروس انتخاب شده
            $this->selectedLessons = $this->selectedLessons->reject(function ($selectedLesson) use ($lessonId) {
                return $selectedLesson->lesten_id == $lessonId;
            });

            //محاسبه زمان کلاس ها - حذف زمان این درس
            $this->classSchedules = array_filter($this->classSchedules, function ($schedule) use ($lessonId) {
                return !str_starts_with($schedule, "{$lessonId} "); // آیتم‌هایی که با ایدی موردنظر شروع می‌شوند حذف می‌شوند
            });

            // محاسبه تعداد کل واحدهای انتخاب شده
            $this->calculateTotalUnits();

            // <<< ذخیره وضعیت موقت در سشن >>>
            $this->updateSessionState();

            // افزایش registered_count در حافظه
            $lesson->registered_count = max(0, $lesson->registered_count - 1);
            LessonOffered::where('lesten_id', $lessonId)->where('registered_count', '>', 0)->decrement('registered_count');

            // به‌روزرسانی تعداد کل واحدها
            $this->calculateTotalUnits();

            // به‌روزرسانی اعتبار حساب
            if ($this->accountService) {
                $this->accountService->updateCredit($lesson->lesten_price); // اصلاح خطا: ubdatCredit -> updateCredit
            }

            // زیرا این سرویس قبلا مقداردهی اولیه شده است
            $statusRecord = null;
            if ($this->lessonStatus) { // اصلاح خطا: lessonStatus service is initialized
                $statusRecord = $this->lessonStatus->where('lesson_id', $lessonId)
                    ->where('student_name', $this->userData->name)
                    ->first();

                if ($statusRecord) {
                    // ابتدا فیلد وضعیت را به‌روزرسانی کن
                    $statusRecord->lesson_status = 'حذف';
                    $statusRecord->save();

                    // سپس رکورد را سافت دیلیت کن
                    $statusRecord->delete();
                }
            }
        }
    }

    /**
     * رندر کردن ویو
     * @return View
     */
    public function render()
    {
        return view('livewire.hazf-ezafe');
    }
}
