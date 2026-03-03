<?php

namespace Solutionforest\FilamentEmail2fa\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;
use Solutionforest\FilamentEmail2fa\Exceptions\InvalidTwoFACodeException;
use Solutionforest\FilamentEmail2fa\Interfaces\RequireTwoFALogin;
use Solutionforest\FilamentEmail2fa\Responses\LoginSuccessResponse;

/**
 * @property Form $form
 */
class TwoFactorAuth extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $layout = 'filament-email-2fa::simple-layout';

    protected static string $view = 'filament-email-2fa::email-sent';

    public ?array $data = [];

    public string $email;

    public static function getLabel(): string
    {
        return __('filament-email-2fa::filament-email-2fa.2sv');
    }

    public static function getRelativeRouteName(): string
    {
        return 'sf-filament-2fa.2fa';
    }

    public function mount()
    {
        if (! Filament::auth()->user() instanceof RequireTwoFALogin) {
            return redirect(Filament::getUrl());
        }
        $this->email = Filament::auth()->user()->email;
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
        Filament::auth()->logout();

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
                ->action('save')
                ->keyBindings(['mod+s']),

            Action::make('resend')
                ->color('gray')
                ->label(__('filament-email-2fa::filament-email-2fa.resend_email'))
                ->action('resend')
                ->keyBindings(['mod+s']),

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
        $model = config("filament-email-2fa.auth_model");

        $user = $model::where('email', $this->email)->first();

        return $user;
    }

    public function getCurrentGuard()
    {
        return Filament::getCurrentPanel()->getAuthGuard();
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('2fa_code')->label(__('filament-email-2fa::filament-email-2fa.2fa-code')),
                    ])
                    ->statePath('data'),
            ),
        ];
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
