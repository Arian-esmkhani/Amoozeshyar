<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\VahedController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\NomreController;
use App\Http\Controllers\profilController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Providers\Filament\AdminPanelProvider;
use Filament\Facades\Filament;
use Filament\Panel;
use App\Http\Middleware\StudentRoleMiddleware;

// مسیر اصلی - اگر کاربر لاگین کرده باشد به main می‌رود، در غیر این صورت به azad
Route::get('/', function () {
    return Auth::check() ? redirect('/amoozeshyar') : view('azad');
})->name('home');

// مسیرهای مهمان
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// مسیرهای نیازمند احراز هویت
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/amoozeshyar', [MainController::class, 'index'])->name('amoozeshyar');
    Route::get('/entekhab', [VahedController::class, 'entekhab'])->name('entekhab-vahed');
    Route::get('/hazve', [VahedController::class, 'hazve'])->name('hazve');
    Route::get('/account', [AccountController::class, 'accountView'])->name('account');
    Route::get('/score', [ScoreController::class, 'scoreView'])->name('score');
    Route::get('/nomre', [NomreController::class, 'nomre'])->name('nomre');
    Route::get('/profil', [profilController::class, 'dashbord'])->name('profil');
});

Route::middleware('auth', 'master')->group(function () {

});

Route::middleware('auth', 'admin')->group(function () {

});

// هنگام اجرای برنامه Filament، این تابع فراخوانی می‌شود
Filament::serving(function () {

    // ثبت یک پنل جدید در Filament
    Filament::registerPanel(

        // دریافت نمونه‌ای از کلاس AdminPanelProvider و ایجاد یک پنل جدید
        app(AdminPanelProvider::class)->panel(new Panel)
    );
});
