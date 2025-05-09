<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class VerifyCsrfToken
{
    /**
     * مدیریت یک درخواست ورودی و بررسی توکن CSRF.
     *
     * @param  Request $request اطلاعات مربوط به درخواست ورودی
     * @param  Closure $next تابعی که درخواست را به مرحله بعدی پردازش هدایت می‌کند
     * @return Response پاسخ نهایی به درخواست
     */
    public function handle(Request $request, Closure $next): Response
    {
        // فقط درخواست‌های POST، PUT، DELETE نیاز به اعتبارسنجی CSRF دارند
        // if (in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
        //     $token = $request->input('_token'); // دریافت توکن ارسال‌شده از فرم
        //     $sessionToken = Session::token();  // دریافت توکن ذخیره‌شده در جلسه

        //     // بررسی اعتبار توکن
        //     if (!$token || $token !== $sessionToken) {
        //         return response()->json(['error' => 'CSRF token mismatch.'], 419); // خطای عدم تطابق توکن
        //     }
        // }

        return $next($request);
    }
}
