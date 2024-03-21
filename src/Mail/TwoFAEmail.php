<?php

namespace Solutionforest\FilamentEmail2fa\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFAEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $name;

    public string $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('filament-email-2fa::filament-email-2fa.2sv'))
            ->view('filament-email-2fa::email-template', ['name' => $this->name, 'code' => $this->code]);
    }
}
