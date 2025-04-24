<?php

namespace App\Http\Controllers;

use App\Models\MasterBase;
use App\Models\UserData;
use App\Models\UserStatus;
use App\Models\LessonOffered;
use App\Models\TermAccess;
use App\Services\CacheService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ScoreController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function scoreView()
    {
        $user = Auth::user();
        $takeListenJson = UserStatus::where('user_id', $user->id)->value('take_listen');
        // $term = UserStatus::where('user_id', $user->id)->value('term');

        $userStatus = UserStatus::where('user_id', $user->id)->first();

        if (!$userStatus) {
            Log::warning("UserStatus not found for user ID: {$user->id}");
            return back()->with('error', 'اطلاعات وضعیت شما یافت نشد.');
        }

        // $term = $userStatus->term;
        $takeListenJson = $userStatus->take_listen;

        /* // موقتا کامنت شد برای تست
        // 1. بررسی دسترسی ترم (فعال سازی مجدد منطق کامنت شده)
        $termAccess = TermAccess::where('term_number', $term)->first();
        if (!$termAccess || !$termAccess->isAccessible()) {
            $errorMessage = $termAccess ? $termAccess->message : 'شما در حال حاضر دسترسی به این ترم ندارید.';
            Log::warning("Term access denied for user ID: {$user->id}, Term: {$term}");
            return back()->with('error', $errorMessage);
        }
        */

        // 2. دیکد کردن و اعتبارسنجی take_listen
        $lessonIds = json_decode($takeListenJson, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($lessonIds)) {
            Log::warning("Invalid or empty take_listen JSON for user ID: {$user->id}", ['json' => $takeListenJson]);
            $lessonIds = [];
        }
        Log::debug("User ID: {$user->id} - Decoded Lesson IDs:", ['lessonIds' => $lessonIds]);

        $cacheKey = 'Master_Score_EvaluationData_' . $user->id;

        $data = $this->cacheService->remember($cacheKey, 14400, function () use ($user, $lessonIds) {

            $userData = UserData::where('user_id', $user->id)->first();
            $evaluationData = [];

            if (!empty($lessonIds)) {
                $lessonsData = LessonOffered::whereIn('lesten_id', $lessonIds)
                    ->select('lesten_id', 'lesten_master', 'lesten_name')
                    ->get();
                Log::debug("User ID: {$user->id} - Lessons found count:", ['count' => $lessonsData->count()]);

                if ($lessonsData->isNotEmpty()) {
                    $masterNames = $lessonsData->pluck('lesten_master')->filter()->unique()->values();
                    Log::debug("User ID: {$user->id} - Extracted Master Names:", ['names' => $masterNames->all()]);

                    $mastersData = collect();
                    if ($masterNames->isNotEmpty()) {
                        $mastersData = MasterBase::whereIn('master_name', $masterNames)
                            ->select('master_name', 'master_score', 'users-save', 'student-id')
                            ->get()
                            ->keyBy('master_name');
                        Log::debug("User ID: {$user->id} - Masters found count:", ['count' => $mastersData->count()]);
                    }

                    $evaluationData = $lessonsData->map(function ($lesson) use ($mastersData) {
                        $masterBase = $mastersData->get($lesson->lesten_master);
                        return [
                            'lesson_id' => $lesson->lesten_id,
                            'lesson_name' => $lesson->lesten_name,
                            'master_name' => $lesson->lesten_master,
                            'master_base' => $masterBase
                        ];
                    })->filter()->values()->all();
                }
            }

            Log::debug("User ID: {$user->id} - Final evaluationData count:", ['count' => count($evaluationData)]);

            return [
                'user' => $user,
                'userData' => $userData,
                'evaluationData' => $evaluationData
            ];
        });

        return view('ScoreView', compact('data'));
    }
}
