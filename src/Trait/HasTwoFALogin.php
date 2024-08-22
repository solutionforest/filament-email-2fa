<?php

namespace Solutionforest\FilamentEmail2fa\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Solutionforest\FilamentEmail2fa\Exceptions\InvalidTwoFACodeException;

trait HasTwoFALogin
{
    public const enable2FALogin = true;

    public function send2FAEmail()
    {
        $emailClass = (string) config('filament-email-2fa.custom_email_class');

        Mail::to(trim($this->email))
            ->send(new $emailClass($this->name, $this->generate2FACode()));
    }

    public function twoFaCodes(): Relation
    {
        return $this->morphMany(config('filament-email-2fa.code_model'), 'user');
    }

    public function twoFaVerifications(): Relation
    {
        return $this->morphMany(config('filament-email-2fa.verify_model'), 'user');
    }

    public function latest2faCode(): Relation
    {
        return $this->morphOne(config('filament-email-2fa.code_model'), 'user')
            ->where('expiry_at', '>=', now())
            ->ofMany('expiry_at', 'max');
    }

    public function generate2FACode(): string
    {
        $this->twoFaCodes()->delete();

        $code = sprintf('%06d', mt_rand(1, 999999));
        $encryptedCode = Crypt::encryptString($code);

        $this->twoFaCodes()->create([
            'code' => $encryptedCode,
            'expiry_at' => now()->addMinutes((int) config('filament-email-2fa.expiry_time_by_mins', 10)),
        ]);

        return $code;
    }

    public function verify2FACode(string $code)
    {
        $encryptedCode = $this->latest2faCode?->code;

        if ($encryptedCode !== null) {
            try {
                $decryptedCode = Crypt::decryptString($encryptedCode);

                if ($code === $decryptedCode) {
                    return;
                }
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Handle decryption failure
            }
        }

        throw new InvalidTwoFACodeException;
    }

    public function isTwoFaVerified(?string $session_id = null): bool
    {
        $session_id = $session_id ?? request()->session()->getId();

        return $this->twoFaVerifications()->where('session_id', $session_id)->exists();
    }
}
