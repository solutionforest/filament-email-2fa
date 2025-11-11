<?php

namespace Solutionforest\FilamentEmail2fa\Pages;

use Filament\Pages\Page;
use Filament\Panel;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @property Schema $form
 */
class LoginSuccessPage extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static string $layout = 'filament-email-2fa::simple-layout';

    protected string $view = 'filament-email-2fa::login-success';

    public ?array $data = [];

    public static function getLabel(): string
    {
        return __('filament-email-2fa::filament-email-2fa.login_success');
    }

    public static function getRelativeRouteName(Panel $panel): string
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
