<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\LessonOffered;
use App\Models\StudentData;
use App\Models\UserGpa;
use App\Models\UserStatus;
use App\Services\CacheService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class VahedController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function entekhab()
    {
        $user = Auth::user();

        $studentMajor = StudentData::where('user_id', $user->id)->value('major');
        $studentSex = UserData::where('user_id', $user->id)->value('gender');
        $passedLesson = UserGpa::where('user_id', $user->id)->value('passed_listen');

        $data = $this->cacheService->remember(
            "lesson_offered_{$user->id}",
            14400,
            function () use ($user, $studentMajor, $studentSex, $passedLesson) {
                // دریافت اطلاعات مرتبط با دانشجو

                $minMax = UserStatus::where('user_id', $user->id)->select('min_unit', 'max_unit')->first();
                $userData = UserData::where('user_id', $user->id)->first();

                // دریافت درس‌های پیشنهادی
                $lessonOffered = LessonOffered::where(function ($query) use ($studentMajor) {
                    $query->whereIn('major', [$studentMajor, 'عمومی', 'مهندسی']);
                })
                ->where(function ($query) use ($studentSex) {
                    $query->whereIn('lesson_sex', [$studentSex, 'open']);

                })
                ->where(function ($query) use ($passedLesson) {
                    $query->where('prerequisites', 'LIKE', "%{$passedLesson}%")
                          ->orWhereNull('prerequisites');
                })
                ->get();


                // بازگرداندن داده‌های درس‌های پیشنهادی و minMax
                return [
                    'lessonOffered' => $lessonOffered,
                    'minMax' => $minMax,
                    'userData' => $userData,
                ];
            }
        );

        return view('entekhab-vahed', compact('data'));
    }
}
