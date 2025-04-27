<?php

namespace App\Http\Controllers; // تعریف فضای نام برای کنترلرها

use App\Models\UserData; // استفاده از مدل UserData
use App\Models\LessonOffered; // استفاده از مدل LessonOffered
use App\Models\StudentData; // استفاده از مدل StudentData
use App\Models\UserGpa; // استفاده از مدل UserGpa
use App\Models\UserStatus; // استفاده از مدل UserStatus
use App\Services\CacheService; // استفاده از سرویس کش
use Illuminate\Routing\Controller; // استفاده از کنترلر پایه
use Illuminate\Support\Facades\Auth; // Auth برای مدیریت احراز هویت
use Illuminate\Support\Facades\Cache; // Cache برای کش کردن داده‌ها

class VahedController extends Controller // تعریف کلاس VahedController که از Controller ارث می‌برد
{
    protected $cacheService; // تعریف یک متغیر برای ذخیره سرویس کش

    // سازنده کلاس که سرویس کش را به عنوان وابستگی دریافت می‌کند
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService; // ذخیره سرویس کش در متغیر
    }

    // متد entekhab که برای انتخاب درس‌ها استفاده می‌شود
    public function entekhab()
    {
        $user = Auth::user(); // دریافت کاربر فعلی

        // دریافت اطلاعات مربوط به رشته و جنسیت دانشجو
        $studentMajor = StudentData::where('user_id', $user->id)->value('major');
        $studentSex = UserData::where('user_id', $user->id)->value('gender');
        $passedLesson = UserGpa::where('user_id', $user->id)->value('passed_listen');

        // استفاده از کش برای ذخیره‌سازی داده‌ها
        $cacheTag = "user-lessons-{$user->id}"; //  کش
        $cacheKey = "lesson_offered_{$user->id}"; // کلید کش

        $data = Cache::tags($cacheTag)->remember(
            $cacheKey,
            14400, // زمان انقضای کش (4 ساعت)
            function () use ($user, $studentMajor, $studentSex, $passedLesson) {
                // دریافت اطلاعات مرتبط با دانشجو
                $minMax = UserStatus::where('user_id', $user->id)->select('min_unit', 'max_unit')->first();
                $userData = UserData::where('user_id', $user->id)->first();
                $userStatus = UserStatus::where('user_id', $user->id)->first();

                // دریافت درس‌های پیشنهادی
                $lessonOffered = LessonOffered::where(function ($query) use ($studentMajor) {
                    $query->whereIn('major', [$studentMajor, 'عمومی', 'مهندسی']);
                })
                ->where(function ($query) use ($studentSex) {
                    $query->whereIn('lesson_sex', [$studentSex, 'open']);
                })
                ->get()
                ->filter(function ($lesson) use ($passedLesson) {
                    // بررسی پیش‌نیازها
                    if (empty($lesson->prerequisites)) {
                        return true; // اگر درس پیش‌نیاز ندارد، می‌تواند انتخاب شود
                    }
                    if (empty($passedLesson)) {
                        return false; // اگر درس پیش‌نیاز دارد و دانشجو هیچ درسی را پاس نکرده
                    }

                    $prerequisites = explode(' ', $lesson->prerequisites); // تبدیل پیش‌نیازها به آرایه
                    $passedLessons = explode(' ', $passedLesson); // تبدیل درس‌های پاس‌شده به آرایه

                    foreach ($prerequisites as $prerequisite) { // حلقه برای بررسی پیش‌نیازها
                        if (!in_array($prerequisite, $passedLessons)) { // اگر یکی از پیش‌نیازها در لیست پاس‌شده نباشد
                            return false; // همه پیش‌نیازها پاس نشده‌اند، مقدار false برمی‌گردد
                        }
                    }

                    return true; // اگر حلقه تمام شود و همه پیش‌نیازها پاس شده باشند، مقدار true برمی‌گردد
                })
                ->values();

                // بازگرداندن داده‌های درس‌های پیشنهادی و minMax
                return [
                    'lessonOffered' => $lessonOffered,
                    'minMax' => $minMax,
                    'userData' => $userData,
                    'userStatus' => $userStatus
                ];
            }
        );

        return view('entekhab-vahed', compact('data')); // بازگشت به نمای entekhab-vahed با داده‌ها
    }

    // متد hazve که برای حذف درس‌ها استفاده می‌شود
    public function hazve()
    {
        $user = Auth::user(); // دریافت کاربر فعلی

        // دریافت اطلاعات مربوط به رشته و جنسیت دانشجو
        $studentMajor = StudentData::where('user_id', $user->id)->value('major');
        $studentSex = UserData::where('user_id', $user->id)->value('gender');
        $passedLesson = UserGpa::where('user_id', $user->id)->value('passed_listen');

        // استفاده از کش برای ذخیره‌سازی داده‌ها
        $cacheTag = "user-lessons-{$user->id}";
        $cacheKey = "lesson_selected_hazf_{$user->id}";

        $data = Cache::tags($cacheTag)->remember(
            $cacheKey,
            14400, // زمان انقضای کش (4 ساعت)
            function () use ($user, $studentMajor, $studentSex, $passedLesson) {
                // دریافت اطلاعات پایه کاربر
                $minMax = UserStatus::where('user_id', $user->id)->select('min_unit', 'max_unit')->first();
                $userData = UserData::where('user_id', $user->id)->first();
                $userStatus = UserStatus::where('user_id', $user->id)->first();

                // دریافت درس‌های انتخاب شده
                $selectedLessons = collect();
                $selectedLessonIds = [];
                if ($userStatus && !empty($userStatus->take_listen)) {
                    $decodedIds = json_decode($userStatus->take_listen, true);
                    $selectedLessonIds = is_array($decodedIds) ? array_values($decodedIds) : [];
                    if (count($selectedLessonIds) > 0) {
                        // دریافت درس‌های انتخاب شده با استفاده از ID ها
                        $selectedLessons = LessonOffered::whereIn('lesten_id', $selectedLessonIds)->get();
                    }
                }

                // دریافت درس‌های پیشنهادی برای اضافه کردن
                $lessonOffered = LessonOffered::where(function ($query) use ($studentMajor) {
                    $query->whereIn('major', [$studentMajor, 'عمومی', 'مهندسی']);
                })
                ->where(function ($query) use ($studentSex) {
                    $query->whereIn('lesson_sex', [$studentSex, 'open']);
                })
                ->get()
                ->filter(function ($lesson) use ($passedLesson) {
                    // بررسی پیش‌نیازها
                    if (empty($lesson->prerequisites)) return true;
                    if (empty($passedLesson)) return false;
                    $prerequisites = explode(' ', $lesson->prerequisites);
                    $passedLessons = explode(' ', $passedLesson);
                    foreach ($prerequisites as $prerequisite) {
                        if (in_array($prerequisite, $passedLessons)) return true;
                    }
                    return false;
                })
                ->values();

                // بازگشت به داده‌ها
                return [
                    'lessonOffered' => $lessonOffered, // درس‌های موجود برای اضافه کردن
                    'selectedLessons' => $selectedLessons, // درس‌های انتخاب شده
                    'minMax' => $minMax,
                    'userData' => $userData,
                ];
            }
        );

        return view('hazf', compact('data')); // بازگشت به نمای hazf با داده‌ها
    }
}

