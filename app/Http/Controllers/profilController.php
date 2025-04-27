<?php

namespace App\Http\Controllers; // تعریف فضای نام برای کنترلرها

use App\Models\UserData; // استفاده از مدل UserData
use App\Models\UserGpa; // استفاده از مدل UserGpa
use App\Models\UserStatus; // استفاده از مدل UserStatus
use App\Models\StudentData; // استفاده از مدل StudentData
use App\Models\LessonOffered; // استفاده از مدل LessonOffered
use App\Services\CacheService; // استفاده از سرویس کش
use Illuminate\Routing\Controller; // استفاده از کنترلر پایه
use Illuminate\Support\Facades\Auth; //Auth برای مدیریت احراز هویت

class profilController extends Controller // تعریف کلاس profilController که از Controller ارث می‌برد
{
    protected $cacheService; // تعریف یک متغیر برای ذخیره سرویس کش

    // سازنده کلاس که سرویس کش را به عنوان وابستگی دریافت می‌کند
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService; // ذخیره سرویس کش در متغیر
    }

    // متد dashbord که برای نمایش داشبورد پروفایل کاربر استفاده می‌شود
    public function dashbord()
    {
        $user = Auth::user(); // دریافت کاربر فعلی
        // دریافت رشته JSON از وضعیت کاربر
        $takeLessonJson = UserStatus::where('user_id', $user->id)->value('take_listen');
        // تبدیل رشته JSON به آرایه، در صورت نادرست بودن یا null به آرایه خالی برمی‌گردد
        $takeLessonIds = json_decode($takeLessonJson, true) ?? [];
        // اطمینان از اینکه آرایه است و فیلتر کردن مقادیر غیر عددی
        $takeLessonIds = is_array($takeLessonIds) ? array_filter($takeLessonIds, 'is_numeric') : [];

        $cacheKey = "user_profil_{$user->id}"; // تعریف کلید کش

        $data = $this->cacheService->remember(
            $cacheKey,
            360, // زمان انقضای کش به ثانیه
            // تابعی که داده‌ها را از پایگاه داده می‌گیرد
            function () use ($user, $takeLessonIds) {
                $userStatus = UserStatus::where('user_id', $user->id)->select('term', 'passed_units')->first(); // وضعیت کاربر
                $studentData = StudentData::where('user_id', $user->id)->select('degree_level', 'major')->first(); // داده‌های دانشجویی
                $userGpa = UserGpa::where('user_id', $user->id)->select('last_gpa', 'cumulative_gpa')->first(); // GPA کاربر
                $userData = UserData::where('user_id', $user->id)->first(); // داده‌های کاربر

                // دریافت درس‌ها با استفاده از آرایه ID های گرفته شده
                $lessons = collect(); // مجموعه خالی به عنوان پیش‌فرض
                if (!empty($takeLessonIds)) {
                    $lessons = LessonOffered::whereIn('lesten_id', $takeLessonIds)->get(); // دریافت درس‌ها
                }

                return [
                    'userStatus' => $userStatus, // وضعیت کاربر
                    'studentData' => $studentData, // داده‌های دانشجویی
                    'userGpa' => $userGpa, // GPA کاربر
                    'userData' => $userData, // داده‌های کاربر
                    'lessons' => $lessons // مجموعه درس‌ها
                ];
            }
        );

        // بازگشت به نمای 'profil' با داده‌های کاربر
        return view('profil', compact('data'));
    }
}

