<?php

namespace Solutionforest\FilamentEmail2fa\Exceptions;

use Exception;

class InvalidTwoFACodeException extends Exception
{
    public $message;

    public function __construct($message = null)
    {
        $this->message = $message ?? __('filament-email-2fa::filament-email-2fa.invalid_code');
    }
}
