<?php

namespace Solutionforest\FilamentEmail2fa;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentEmail2faPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-email-2fa';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
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
