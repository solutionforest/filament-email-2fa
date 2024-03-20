<?php

namespace Solutionforest\FilamentEmail2fa\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @property Form $form
 */
class LoginSuccessPage extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static string $layout = 'filament-panels::components.layout.simple';

    protected static string $view = 'filament-email-2fa::login-success';

    public ?array $data = [];

    public static function getLabel(): string
    {
        return __('filament-email-2fa.login_success');
    }

    public static function getRelativeRouteName(): string
    {
        return 'sf-filament-2fa.login-success';
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
