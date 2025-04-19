<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserGpa;
use App\Models\UserStatus;
use App\Models\StudentData;
use App\Models\LessonOffered;
use App\Services\CacheService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class profilController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function dashbord()
    {
        $user = Auth::user();
        $takeLesson = UserStatus::whereJsonContains('user_id', $user->id)->value('take_listen');

        $data = $this->cacheService->remember(
            "user_profil_{$user->id}",
            360,
            function () use ($user, $takeLesson)
            {
                $userStatus = UserStatus::where('user_id', $user->id)->select('term', 'passed_units')->first();
                $studentData = StudentData::where('user_id', $user->id)->select('degree_level', 'major')->first();
                $userGpa = UserGpa::where('user_id', $user->id)->select('last_gpa', 'cumulative_gpa')->first();
                $userData = UserData::where('user_id', $user->id)->value('name');
                $lessons = LessonOffered::where('lesten_id', $takeLesson)->first();

                return [
                    'userStatus' => $userStatus,
                    'studentData' => $studentData,
                    'userGpa' => $userGpa,
                    'userData' => $userData,
                    'lessons' => $lessons
                ];
            }
        );
        return view('profil', compact('data'));
    }
}
