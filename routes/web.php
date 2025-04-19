<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\VahedController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

// مسیر اصلی - اگر کاربر لاگین کرده باشد به main می‌رود، در غیر این صورت به azad
Route::get('/', function () {
    return Auth::check() ? redirect('/main') : view('azad');
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
    Route::get('/account', [AccountController::class, 'accountView'])->name('account');
    Route::get('/score', [AccountController::class, 'scoreView'])->name('score');
});
