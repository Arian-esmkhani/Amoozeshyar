<?php

namespace App\Jobs;

use App\Models\UserBase;
use App\Services\CacheService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessUserLogin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $userId;

    public function __construct(UserBase $user)
    {
        $this->userId = $user->id;
    }

    public function handle(CacheService $cacheService): void
    {
        try {
            $user = UserBase::find($this->userId);
            if (!$user) {
                return;
            }

            // Cache user data
            $cacheService->getUserFromCache($user->id);

            // Log login event
            Log::info('User logged in', [
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing user login', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
