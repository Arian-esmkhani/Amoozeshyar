<?php

namespace App\Http\Controllers;

use App\Models\MasterBase;
use App\Models\UserData;
use App\Models\UserStatus;
use App\Models\LessonOffered;
use App\Services\CacheService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function scoreView()
    {
        $user = Auth::user();
        $take_listen = UserStatus::where('user_id', $user->id)->value('take_listen');


        $data = $this->cacheService->remember(
            'Master_Score_' . $user->id,
            120,
            function () use ($user, $take_listen) {

                $user = $user;
                $userData = UserData::where('user_id', $user->id)->first();
                $lessonDeta = LessonOffered::whereJsonContains('lesten_id' , $take_listen)->value('lesten_master');
                $lessonName = LessonOffered::whereJsonContains('lesten_id' , $take_listen)->value('lesten_name');

                $masterBase = MasterBase::where('master_name', $lessonDeta)->select('master_name', 'master_score')->first();

                return [
                    'user' => $user,
                    'userData' => $userData,
                    'lesssonData' => $lessonDeta,
                    'lessonName' => $lessonName,
                    'masterBase' => $masterBase
                ];
            }
        );
        return view('ScoreView', compact('data'));
    }
}