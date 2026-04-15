<?php

namespace Solutionforest\FilamentEmail2fa\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;
use Solutionforest\FilamentEmail2fa\Exceptions\InvalidTwoFACodeException;
use Solutionforest\FilamentEmail2fa\Interfaces\RequireTwoFALogin;
use Solutionforest\FilamentEmail2fa\Responses\LoginSuccessResponse;

/**
 * @property Schema $form
 */
class TwoFactorAuth extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $layout = 'filament-email-2fa::simple-layout';

    protected string $view = 'filament-email-2fa::email-sent';

    public ?array $data = [];

    public string $email;

    public static function getLabel(): string
    {
        return __('filament-email-2fa::filament-email-2fa.2sv');
    }

    public static function getRelativeRouteName(Panel $panel): string
    {
        return 'sf-filament-2fa.2fa';
    }

    public function mount()
    {
        if (! auth()->user() instanceof RequireTwoFALogin) {
            return redirect(Filament::getUrl());
        }
        $this->email = auth()->user()->email;
        $this->email = auth()->user()->email;
        if (! $this->getUser()->latest_2fa_code()->exists()) {
            $this->getUser()->send2FAEmail();
        }
    }

    public function resend()
    {

        if ($user = $this->getUser()) {
            $user->send2FAEmail();
            session()->flash('resent-success', __('filament-email-2fa::filament-email-2fa.resend_success'));

            return;
        }
    }

    public function logout()
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->to(
            Filament::hasLogin() ? Filament::getLoginUrl() : Filament::getUrl(),
        );
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-email-2fa::filament-email-2fa.confirm'))
                ->submit('save')
                ->keyBindings(['mod+s']),

            Action::make('resend')
                ->color('gray')
                ->label(__('filament-email-2fa::filament-email-2fa.resend_email'))
                ->action('resend'),

            Action::make('logout')
                ->color('gray')
                ->label(__('filament-email-2fa::filament-email-2fa.use_another_ac'))
                ->action('logout'),
        ];
    }

    public function save()
    {

        $code = $this->data['2fa_code'] ?? null;

        try {
            if ($user = $this->getUser()) {
                $user->verify2FACode($code ?? '');
                $user->twoFaVerifis()->create([
                    'session_id' => request()->session()->getId(),
                ]);

                return app(LoginSuccessResponse::class);
            } else {
                throw new InvalidTwoFACodeException;
            }
        } catch (InvalidTwoFACodeException $e) {
            $this->addError('data.2fa_code', $e->getMessage());

            return;
        }
    }

    public function getUser()
    {
        $guard = $this->getCurrentGuard();
        $model = config("auth.providers.{$guard}.model");

        $user = $model::where('email', $this->email)->first();

        return $user;
    }

    public function getCurrentGuard()
    {
        return Filament::getCurrentPanel()->getAuthGuard();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('2fa_code')->label(__('filament-email-2fa::filament-email-2fa.2fa-code')),
            ])
            ->statePath('data');
    }

    public function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function getFormActionsAlignment(): string | Alignment
    {
        return Alignment::Start;
    }

    public function getTitle(): string | Htmlable
    {
        return static::getLabel();
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
