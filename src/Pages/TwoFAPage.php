<?php

namespace Solutionforest\FilamentEmail2fa\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @property Form $form
 */
class TwoFactorAuth extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $layout = 'filament-panels::components.layout.simple';

    protected static string $view = 'filament-email-2fa::email-sent';

    public ?array $data = [];

    public static function getLabel(): string
    {
        return __('filament-email-2fa.2sv');
    }

    public static function getRelativeRouteName(): string
    {
        return 'sf-filament-2fa.2fa';
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-email-2fa.confirm'))
                ->submit('save')
                ->keyBindings(['mod+s']),

            Action::make('resend')
                ->color('gray')
                ->label(__('filament-email-2fa.resend_email'))
                ->submit('resend')
                ->keyBindings(['mod+s']),
        ];
    }

    public function save()
    {
        Filament::auth()->user()->update(['two_factor_confirmed_at' => now()]);

        if (Filament::getCurrentPanel()->getId() == 'ngo') {
            $redirectUrl = route('filament.ngo.home');
        } else {
            $redirectUrl = route('filament.jccct.pages.dashboard');
        }
        $this->redirect($redirectUrl);
    }

    public function getUser()
    {
        return Filament::auth()->user();
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
                        // $this->getPasswordFormComponent(),
                        // $this->getPasswordConfirmationFormComponent(),
                        TextInput::make('2fa_code')->label('2FA Code'),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data'),
            ),
        ];
    }

    public function hasFullWidthFormActions(): bool
    {
        return false;
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s']);
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

    protected function getSavedNotification(): ?Notification
    {
        $title = $this->getSavedNotificationTitle();

        if (blank($title)) {
            return null;
        }

        return Notification::make()
            ->success()
            ->title($this->getSavedNotificationTitle());
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('filament-panels::resources/pages/edit-record.notifications.saved.title');
    }
}
