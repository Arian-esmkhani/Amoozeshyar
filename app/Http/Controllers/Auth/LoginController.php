<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // پایه کنترلرهای لاراول
use App\Services\AuthService; // سرویس احراز هویت
use Illuminate\Http\Request; // مدیریت درخواست‌های HTTP
use Illuminate\Support\Facades\Auth; // احراز هویت لاراول
use Illuminate\Validation\ValidationException; // خطای اعتبارسنجی

/**
 * کنترلر مدیریت ورود و خروج کاربران
 *
 * این کنترلر مسئولیت مدیریت فرآیند احراز هویت کاربران را بر عهده دارد
 * و از سرویس AuthService برای انجام عملیات‌های مربوط به احراز هویت استفاده می‌کند
 */
class LoginController extends Controller
{
    /**
     * سرویس احراز هویت
     *
     * این سرویس مسئولیت انجام عملیات‌های مربوط به احراز  را بر عهده دارد
     */
    private AuthService $authService;

    /**
     * سازنده کلاس
     *
     * @param AuthService $authService سرویس احراز هویت
     *
     * این متد سرویس احراز هویت را تزریق می‌کند و middleware مربوط به
     * دسترسی مهمانان را تنظیم می‌کند
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        // فقط کاربران مهمان می‌توانند به این کنترلر دسترسی داشته باشند
        // به جز متد logout که باید برای کاربران وارد شده قابل دسترسی باشد
        $this->middleware('guest')->except('logout');
    }

    /**
     * نمایش فرم ورود
     *
     * @return \Illuminate\View\View
     *
     * این متد صفحه ورود را نمایش می‌دهد که شامل فرم ورود با فیلدهای
     * نام کاربری و رمز عبور است
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * پردازش درخواست ورود
     *
     * @param Request $request درخواست ورود شامل نام کاربری و رمز عبور
     * @return \Illuminate\Http\RedirectResponse
     *
     * این متد اطلاعات ورود را اعتبارسنجی می‌کند و در صورت معتبر بودن
     * کاربر را وارد سیستم می‌کند و به صفحه اصلی هدایت می‌کند
     */
    public function login(Request $request)
    {
        // اعتبارسنجی اطلاعات ورود
        // نام کاربری و رمز عبور باید حتماً پر شده باشند
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        try {
            // تلاش برای ورود کاربر با استفاده از سرویس احراز هویت
            $result = $this->authService->login($credentials);

            // بازنشانی نشست برای جلوگیری از حملات CSRF
            $request->session()->regenerate();

            // هدایت به صفحه اصلی یا صفحه‌ای که کاربر قصد دسترسی به آن را داشت
            return redirect()->intended('/amoozeshyar');
        } catch (ValidationException $e) {
            // در صورت خطا، برگشت به صفحه ورود با پیام خطا
            // و حفظ اطلاعات وارد شده توسط کاربر
            return back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * پردازش درخواست خروج
     *
     * @param Request $request درخواست خروج
     * @return \Illuminate\Http\RedirectResponse
     *
     * این متد کاربر را از سیستم خارج می‌کند، نشست را باطل می‌کند
     * و توکن CSRF را بازنشانی می‌کند
     */
    public function logout(Request $request)
    {
        // خروج کاربر با استفاده از سرویس احراز هویت
        $this->authService->logout();

        // باطل کردن نشست برای امنیت بیشتر
        $request->session()->invalidate();
        // بازنشانی توکن CSRF برای جلوگیری از حملات
        $request->session()->regenerateToken();

        // هدایت به صفحه اصلی سایت
        return redirect('/');
    }
}
