<?php

namespace Solutionforest\FilamentEmail2fa\Commands;

use Illuminate\Console\Command;

class FilamentEmail2faCommand extends Command
{
    public $signature = 'filament-email-2fa';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
