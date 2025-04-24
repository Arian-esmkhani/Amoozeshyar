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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class VahedController extends Controller
{
    // protected $cacheService;

    /*
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    */

    public function entekhab()
    {
        $user = Auth::user();

        $studentMajor = StudentData::where('user_id', $user->id)->value('major');
        $studentSex = UserData::where('user_id', $user->id)->value('gender');
        $passedLesson = UserGpa::where('user_id', $user->id)->value('passed_listen');

        // Use Cache Facade directly with Tags for entekhab as well
        $cacheTag = "user-lessons-{$user->id}"; // Use the same tag
        $cacheKey = "lesson_offered_{$user->id}"; // Original key for entekhab

        $data = Cache::tags($cacheTag)->remember(
            $cacheKey,
            14400, // Cache duration
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
                        // اگر درس پیش‌نیاز ندارد، می‌تواند انتخاب شود
                        if (empty($lesson->prerequisites)) {
                            return true;
                        }

                        // اگر درس پیش‌نیاز دارد و دانشجو هیچ درسی را پاس نکرده
                        if (empty($passedLesson)) {
                            return false;
                        }

                        // بررسی پیش‌نیازها
                        $prerequisites = explode(' ', $lesson->prerequisites);
                        $passedLessons = explode(' ', $passedLesson);

                        // بررسی می‌کند که آیا حداقل یکی از پیش‌نیازها در دروس پاس شده وجود دارد
                        foreach ($prerequisites as $prerequisite) {
                            if (in_array($prerequisite, $passedLessons)) {
                                return true;
                            }
                        }

                        return false;
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

        return view('entekhab-vahed', compact('data'));
    }

    public function hazve()
    {
        $user = Auth::user();

        $studentMajor = StudentData::where('user_id', $user->id)->value('major');
        $studentSex = UserData::where('user_id', $user->id)->value('gender');
        $passedLesson = UserGpa::where('user_id', $user->id)->value('passed_listen');

        // Use Cache Facade directly with Tags
        $cacheTag = "user-lessons-{$user->id}";
        $cacheKey = "lesson_selected_hazf_{$user->id}";

        $data = Cache::tags($cacheTag)->remember(
            $cacheKey,
            14400, // Cache duration (4 hours)
            function () use ($user, $studentMajor, $studentSex, $passedLesson) {
                // Get basic user info first
                $minMax = UserStatus::where('user_id', $user->id)->select('min_unit', 'max_unit')->first();
                $userData = UserData::where('user_id', $user->id)->first();
                $userStatus = UserStatus::where('user_id', $user->id)->first();

                // --- Get ACTUAL Selected Lessons based on take_listen ---
                $selectedLessons = collect();
                $selectedLessonIds = [];
                if ($userStatus && !empty($userStatus->take_listen)) {
                    $decodedIds = json_decode($userStatus->take_listen, true);
                    $selectedLessonIds = is_array($decodedIds) ? array_values($decodedIds) : [];
                    if (count($selectedLessonIds) > 0) {
                        // Fetch selected lessons directly using IDs
                        $selectedLessons = LessonOffered::whereIn('lesten_id', $selectedLessonIds)->get();
                    }
                }
                // --- End Getting Selected Lessons ---

                // --- Get Lessons Offered FOR ADDING (Apply filters) ---
                $lessonOffered = LessonOffered::where(function ($query) use ($studentMajor) {
                    $query->whereIn('major', [$studentMajor, 'عمومی', 'مهندسی']);
                })
                    ->where(function ($query) use ($studentSex) {
                        $query->whereIn('lesson_sex', [$studentSex, 'open']);
                    })
                    // Optionally filter out already selected lessons from offered list?
                    // ->whereNotIn('lesten_id', $selectedLessonIds)
                    ->get()
                    ->filter(function ($lesson) use ($passedLesson) {
                        // Prerequisite check logic...
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
                // --- End Getting Offered Lessons ---

                // Return both lists and other data
                return [
                    'lessonOffered' => $lessonOffered, // Lessons available to ADD
                    'selectedLessons' => $selectedLessons, // ACTUAL selected lessons
                    'minMax' => $minMax,
                    'userData' => $userData,
                ];
            }
        );

        return view('hazf', compact('data'));
    }
}
