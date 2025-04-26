<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventRequestsDuringMaintenance
{
    //مدیریت یک درخواست ورودی در حالت نگهداری.
    public function handle(Request $request, Closure $next): Response
    {
        // بررسی فعال بودن حالت نگهداری
        if ($this->isMaintenanceMode()) {
            // هدایت کاربر به صفحه "در حال تعمیر"
            return response()->view('maintenance')->setStatusCode(503);
        }

        // اگر حالت نگهداری فعال نباشد، درخواست به مرحله بعدی ارسال می‌شود
        return $next($request);
    }

    /**
     * بررسی فعال بودن حالت نگهداری.
     *
     * @return bool
     *    بازگشت مقدار صحیح (true) در صورت فعال بودن حالت نگهداری.
     */
    protected function isMaintenanceMode(): bool
    {
        return config('app.maintenance', false);
    }
}