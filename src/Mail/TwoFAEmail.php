<?php

namespace Solutionforest\FilamentEmail2fa\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class TwoFAEmail extends Mailable
{
    use Queueable, SerializesModels;

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
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('filament-email-2fa::filament-email-2fa.2sv'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'filament-email-2fa::email-template',
            with: ['name' => $this->name, 'code' => $this->code]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}