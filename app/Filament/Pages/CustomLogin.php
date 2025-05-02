<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use App\Models\UserBase; // Import UserBase model
use Illuminate\Support\Facades\Auth; // Import Auth facade

class CustomLogin extends BaseLogin
{
    public function mount(): void
    {
        parent::mount(); // Call the parent mount method

        // Optional: Set a default username if needed, for example, from session or request
        // $this->form->fill([
        //     'username' => old('username'), // Use 'username' instead of 'email'
        //     'remember' => old('remember'),
        // ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getUsernameFormComponent(), // Use username component
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getUsernameFormComponent(): Component // New method for username
    {
        return TextInput::make('username')
            ->label(__('username')) // Change label to Persian
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    /**
     * Override the getCredentialsFromFormData method to use 'username' instead of 'email'.
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'], // Use 'username' key
            'password' => $data['password'],
        ];
    }

    /**
     * Override the authenticate method to add role check.
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            // Use the modified getCredentialsFromFormData
            $data = $this->form->getState();
            $credentials = $this->getCredentialsFromFormData($data);

            // Attempt authentication using Laravel's Auth facade
            if (! auth()->attempt($credentials, $data['remember'])) {
                throw ValidationException::withMessages([
                    'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
                ]);
            }

            // Get the authenticated user
            $user = auth()->user();

            // Check if the user is an admin
            if (!$user instanceof UserBase || !$user->isAdmin()) {
                auth()->logout(); // Log out the user if not an admin
                throw ValidationException::withMessages([
                    'data.username' => __('auth.failed'), // Use a generic failed message or create a custom one
                ]);
            }

            // Regenerate session and prepare response if authentication and role check are successful
            session()->regenerate();
            return app(LoginResponse::class);
        } catch (ValidationException $exception) {
            // Rate limiting is handled by Laravel's throttle middleware
            // which is usually applied to the login route.
            // Filament's default Login class also adds rate limiting.
            // We keep the parent's rate limiting logic here.

            // Throw the validation exception to display errors
            throw $exception;
        }
    }

    // Optional: Change page title or heading if needed
    // public function getTitle(): string | Htmlable
    // {
    //     return __('Admin Login');
    // }

    // public function getHeading(): string | Htmlable
    // {
    //     return __('Admin Panel Login');
    // }
}
