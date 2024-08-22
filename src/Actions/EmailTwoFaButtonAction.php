<?php

namespace Solutionforest\FilamentEmail2fa\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Solutionforest\FilamentEmail2fa\Exceptions\InvalidTwoFACodeException;
use Filament\Notifications\Notification;

class EmailTwoFaButtonAction extends Action
{
    protected function isPasswordSessionValid(): bool
    {
        $passwordTimeout = config('auth.password_timeout', 3600);
        return session()->has('auth.password_confirmed_at') &&
            (time() - session('auth.password_confirmed_at', 0)) < $passwordTimeout;
    }

    protected function getUser()
    {
        $guard = Filament::getCurrentPanel()->getAuthGuard();
        $provider = config("auth.guards.{$guard}.provider");
        $model = config("auth.providers.{$provider}.model");

        if (!class_exists($model)) {
            throw new \RuntimeException("User model {$model} does not exist.");
        }

        $user = $model::where('email', Filament::auth()->user()->email)->first();

        if (!$user) {
            throw new \RuntimeException(__('filament-email-2fa::filament-email-2fa.email_user_not_found'));
        }

        return $user;
    }

    protected function setUp(): void
    {
        parent::setUp();

        if (! $this->isPasswordSessionValid()) {
            $this->requiresConfirmation()
                ->modalHeading(__('filament-email-2fa::filament-email-2fa.email_otp_heading'))
                ->modalDescription(__('filament-email-2fa::filament-email-2fa.email_otp_description'))
                ->extraModalFooterActions([
                    Action::make('resend')
                        ->label(__('filament-email-2fa::filament-email-2fa.resend_email'))
                        ->color('warning')
                        ->action(function () {
                            $this->resendOtp();
                        })
                        ->icon('heroicon-s-arrow-path'),
                ])
                ->modalCancelAction(false)
                ->form([
                    TextInput::make('otp_code')
                        ->label(__('filament-email-2fa::filament-email-2fa.email_otp_code'))
                        ->required()
                        ->password()
                        ->rules('required|numeric|digits:6'),
                ])
                ->mountUsing(function (Form $form) {
                    $form->fill();

                    try {
                        $this->getUser();
                    } catch (\RuntimeException $e) {
                        Notification::make()
                            ->title($e->getMessage())
                            ->danger()
                            ->send();
                        $this->halt();
                    }

                    // Send the 2FA email
                    // $user->send2FAEmail();
                });
        }
    }

    public function call(array $data = []): mixed
    {
        $formData = $this->getFormData();

        try {
            $user = $this->getUser();
            $user->verify2FACode($formData['otp_code'] ?? '');

            // If the session already has a cookie and it's still valid, we don't want to reset the time on it.
            if (! $this->isPasswordSessionValid()) {
                session(['auth.password_confirmed_at' => time()]);
            }
        } catch (\RuntimeException | InvalidTwoFACodeException $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
            $this->halt();
        }

        return parent::call($data);
    }

    protected function resendOtp()
    {
        try {
            $user = $this->getUser();
            $user->send2FAEmail();
            Notification::make()
                ->title(__('filament-email-2fa::filament-email-2fa.email_resend_success'))
                ->success()
                ->send();
        } catch (\RuntimeException $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
