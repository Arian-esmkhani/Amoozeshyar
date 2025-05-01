<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMid
{
    /**
     * بررسی دسترسی کاربران بر اساس نقش (role)
     */
    public function handle(Request $request, Closure $next)
    {
        // بررسی اینکه آیا کاربر وارد شده است
        if (Auth::check()) {
            $user = Auth::user();

            // بررسی نقش کاربر
            if ($user->role === 'admin') {
                return $next($request); // اجازه‌ی دسترسی به مسیر
            }
        }

        // اگر کاربر مجاز نبود، هدایت به مسیر دیگر
        return redirect('/amoozeshyar')->withErrors(['error' => 'شما مجاز به دسترسی نیستید.']);
    }
}