<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use App\Models\UserBase; // ایمپورت مدل UserBase
use Illuminate\Support\Facades\Auth; // ایمپورت Auth

class CustomLogin extends BaseLogin
{
    public function mount(): void
    {
        parent::mount(); // فراخوانی متد mount والد

        // تنظیم مقدار پیش‌فرض برای نام کاربری در صورت نیاز (مثلاً از سشن یا درخواست)
        // $this->form->fill([
        //     'username' => old('username'),
        //     'remember' => old('remember'),
        // ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getUsernameFormComponent(), // استفاده از کامپوننت نام کاربری
                        $this->getPasswordFormComponent(), // کامپوننت رمز عبور
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getUsernameFormComponent(): Component // متد جدید برای نام کاربری
    {
        return TextInput::make('username')
            ->label(__('username')) // تغییر لیبل به فارسی
            ->required()
            ->autocomplete()
            ->autofocus();
    }


    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'], // استفاده از کلید 'username'
            'password' => $data['password'],
        ];
    }

    /**
     * بازنویسی متد authenticate برای اضافه‌کردن بررسی نقش.
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            // دریافت داده‌های فرم
            $data = $this->form->getState();
            $credentials = $this->getCredentialsFromFormData($data);

            // تلاش برای احراز هویت با استفاده از فاساد Auth
            if (! Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
                ]);
            }

            // دریافت کاربر احراز هویت‌شده
            $user = Auth::user();

            // بررسی نقش کاربر (مدیر باشد)
            if (!$user instanceof UserBase || !$user->isAdmin()) {
                Auth::logout(); // خروج کاربر در صورت عدم تأیید نقش
                throw ValidationException::withMessages([
                    'data.username' => __('auth.failed'), // پیام خطای عمومی یا سفارشی
                ]);
            }

            // بازسازی سشن و آماده‌سازی پاسخ در صورت موفقیت احراز هویت و بررسی نقش
            session()->regenerate();
            return app(LoginResponse::class);
        } catch (ValidationException $exception) {
            // پرتاب استثناء اعتبارسنجی برای نمایش خطاها
            throw $exception;
        }
    }
}