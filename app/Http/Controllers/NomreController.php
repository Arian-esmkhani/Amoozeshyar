<?php

namespace App\Http\Controllers;

use App\Models\LessonStatus;
use App\Models\UserData;
use App\Services\CacheService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class NomreController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function nomre()
    {
        $user = Auth::user();
        $masterName = UserData::where('user_id', $user->id)->value('name');

        $data = $this->cacheService->remember(
            "student_nomre_{$user->id}",
            360,
            function () use ($user, $masterName) {
                $lessonStatus = LessonStatus::where('master_name' , $masterName) ->get();
                $userData = UserData::where('user_id', $user->id)->first();

                return [
                    'lessonStatus' => $lessonStatus,
                    'userData' => $userData
                ];
            }
        );

        return view('nomreView', compact('data'));
    }
}