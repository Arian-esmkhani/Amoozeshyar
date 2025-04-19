<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use App\Models\UserData;
use App\Services\CacheService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function accountView()
    {
        $user = Auth::user();

        $data = $this->cacheService->remember(
            'user_account_' . $user->id,
            120,
            function () use ($user) {
                $userData = UserData::where('user_id', $user->id)->first();

                $userAccount = UserAccount::where('user_id', $user->id)->select('balance', 'debt', 'credit', 'payment_status')->first();

                return [
                    'userData' => $userData,
                    'userAccount' => $userAccount
                ];
            }
        );


        return view('account', compact('data'));
    }
}