<?php

namespace App\Http\Controllers;

use App\Models\UserBase;
use App\Models\UserData;
use App\Services\CacheService;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function index()
    {
        $user = Auth::user();
        $userData = $this->cacheService->remember(
            "user_data_{$user->id}",
            3600,
            fn() => UserData::where('user_id', $user->id)->first()
        );

        return view('main', [
            'userData' => $userData,
            'userRole' => $user->role
        ]);
    }
}
