<?php

namespace Solutionforest\FilamentEmail2fa;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Solutionforest\FilamentEmail2fa\Middlewares\IsTwoFAVerified;
use Solutionforest\FilamentEmail2fa\Pages\LoginSuccessPage;
use Solutionforest\FilamentEmail2fa\Pages\TwoFactorAuth;

class FilamentEmail2faPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-email-2fa';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            TwoFactorAuth::class,
            LoginSuccessPage::class,
        ])
            ->authMiddleware([
                IsTwoFAVerified::class,
            ]);

    }

    public function boot(Panel $panel): void
    {

    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
