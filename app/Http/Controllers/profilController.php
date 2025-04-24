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
        // Get the JSON string
        $takeLessonJson = UserStatus::where('user_id', $user->id)->value('take_listen');
        // Decode the JSON string into an array, default to empty array if null or invalid
        $takeLessonIds = json_decode($takeLessonJson, true) ?? [];
        // Ensure it's an array and filter out any non-numeric values just in case
        $takeLessonIds = is_array($takeLessonIds) ? array_filter($takeLessonIds, 'is_numeric') : [];

        $cacheKey = "user_profil_{$user->id}"; // Define cache key outside closure

        $data = $this->cacheService->remember(
            $cacheKey,
            360,
            // Pass the decoded IDs to the closure
            function () use ($user, $takeLessonIds) {
                $userStatus = UserStatus::where('user_id', $user->id)->select('term', 'passed_units')->first();
                $studentData = StudentData::where('user_id', $user->id)->select('degree_level', 'major')->first();
                $userGpa = UserGpa::where('user_id', $user->id)->select('last_gpa', 'cumulative_gpa')->first();
                // Fetch user name directly, not just the value if you need the object later (though value is fine if only name is needed)
                $userData = UserData::where('user_id', $user->id)->first(); // Get the model instance

                // Fetch lessons using the decoded IDs array with whereIn and get()
                $lessons = collect(); // Default to empty collection
                if (!empty($takeLessonIds)) {
                    $lessons = LessonOffered::whereIn('lesten_id', $takeLessonIds)->get();
                }


                return [
                    'userStatus' => $userStatus,
                    'studentData' => $studentData,
                    'userGpa' => $userGpa,
                    'userData' => $userData, // Pass the user data object
                    'lessons' => $lessons // Pass the collection of lessons
                ];
            }
        );

        // Render the standard Blade view 'profil' located at resources/views/profil.blade.php
        return view('profil', compact('data'));
    }
}
