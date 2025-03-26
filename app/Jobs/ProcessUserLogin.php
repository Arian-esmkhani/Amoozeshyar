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

    private UserBase $user;
    private CacheService $cacheService;

    public function __construct(UserBase $user, CacheService $cacheService)
    {
        $this->user = $user;
        $this->cacheService = $cacheService;
    }

    public function handle(): void
    {
        try {
            // Cache user data
            $this->cacheService->getUserFromCache($this->user->id);

            // Log login event
            Log::info('User logged in', [
                'user_id' => $this->user->id,
                'username' => $this->user->username,
                'role' => $this->user->role,
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing user login', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
