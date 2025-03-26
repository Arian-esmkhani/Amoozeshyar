<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserBase;
use App\Models\UserData;
use App\Models\UserAccount;
use App\Models\UserGpa;
use App\Models\StudentData;
use App\Models\UserStatus;
use App\Models\LoginHistory;
use App\Models\LestenOffered;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ایجاد کاربر ادمین
        $admin = UserBase::factory()->admin()->create();
        UserData::factory()->create(['user_id' => $admin->id]);
        UserAccount::factory()->create(['user_id' => $admin->id]);
        UserGpa::factory()->create(['user_id' => $admin->id]);
        StudentData::factory()->create(['user_id' => $admin->id]);
        UserStatus::factory()->create(['user_id' => $admin->id]);
        LoginHistory::factory()->count(5)->create(['user_id' => $admin->id]);

        // ایجاد کاربر استاد
        $teacher = UserBase::factory()->teacher()->create();
        UserData::factory()->create(['user_id' => $teacher->id]);
        UserAccount::factory()->create(['user_id' => $teacher->id]);
        UserGpa::factory()->create(['user_id' => $teacher->id]);
        StudentData::factory()->create(['user_id' => $teacher->id]);
        UserStatus::factory()->create(['user_id' => $teacher->id]);
        LoginHistory::factory()->count(5)->create(['user_id' => $teacher->id]);

        // ایجاد کاربران دانشجو
        UserBase::factory()->count(10)->student()->create()->each(function ($user) {
            UserData::factory()->create(['user_id' => $user->id]);
            UserAccount::factory()->create(['user_id' => $user->id]);
            UserGpa::factory()->create(['user_id' => $user->id]);
            StudentData::factory()->create(['user_id' => $user->id]);
            UserStatus::factory()->create(['user_id' => $user->id]);
            LoginHistory::factory()->count(3)->create(['user_id' => $user->id]);
        });

        // ایجاد درس‌های ارائه شده
        LestenOffered::factory()->count(20)->create();
    }
}
