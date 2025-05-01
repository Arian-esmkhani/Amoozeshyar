<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserStatus;
use App\Models\LessonOffered;
use App\Services\CacheService;
use Illuminate\Support\Facades\Auth;



class ScoreController extends Controller
{
    protected $cacheService; // تعریف یک متغیر برای ذخیره سرویس کش

    // سازنده کلاس که سرویس کش را به عنوان وابستگی دریافت می‌کند
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService; // ذخیره سرویس کش در متغیر
    }

    public function scoreView()
    {
        $user = Auth::user(); // دریافت کاربر فعلی
        $userStatus = UserStatus::where('user_id', $user->id)->first();

        $takedLesson = json_decode($userStatus->take_listen, true);

        $selectedLessonIds = [];
        $selectedLessonIds = is_array($takedLesson) ? array_values($takedLesson) : [];

        $data = $this->cacheService->remember(
            "master-base-{$user->id}",
            3000,
            function () use ($user, $selectedLessonIds) {

                $userData = UserData::where('user_id', $user->id)->select('user_id', 'name')->first();

                $lessonMaster = collect();
                if (count($selectedLessonIds) > 0) {
                    // دریافت درس‌های انتخاب شده با استفاده از ID ها
                    $lessonMaster = LessonOffered::whereIn('lesten_id', $selectedLessonIds)->pluck('lesten_master')->unique();
                }

                return [
                    'userData' => $userData,
                    'lessonMaster' => $lessonMaster,
                ];
            }
        );

        return view('ScoreView', compact('data'));
    }
}
