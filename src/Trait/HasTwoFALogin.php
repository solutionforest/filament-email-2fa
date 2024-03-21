<?php

namespace Solutionforest\FilamentEmail2fa\Trait;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Mail;
use Solutionforest\FilamentEmail2fa\Exceptions\InvalidTwoFACodeException;
use Solutionforest\FilamentEmail2fa\Mail\TwoFAEmail;

trait HasTwoFALogin
{
    public const enable2FALogin = true;

    public function send2FAEmail()
    {
        Mail::to(trim($this->email))
            ->send(new TwoFAEmail($this->name, $this->generate2FACode()));
    }

    public function twoFaCodes(): Relation
    {
        return $this->morphMany(config('filament-email-2fa.code_model'), 'user');
    }

    public function twoFaVerifis(): Relation
    {
        return $this->morphMany(config('filament-email-2fa.verify_model'), 'user');
    }

    public function latest_2fa_code(): Relation
    {
        return $this->morphOne(config('filament-email-2fa.code_model'), 'user')->where('expiry_at', '>=', now())->ofMany('expiry_at', 'max');
    }

    public function generate2FACode(): string
    {
        $this->twoFaCodes()->delete();
        $code = sprintf('%06d', mt_rand(1, 999999));
        $this->twoFaCodes()->create([
            'code' => $code,
            'expiry_at' => now()->addMinutes((int) config('filament-email-2fa.expiry_time_by_mins', 10)),
        ]);

        return $code;

    }

    public function verify2FACode(string $code)
    {
        $latestCode = $this->latest_2fa_code?->code;
        if ($code !== null && $code === $latestCode) {
            return;
        }

        throw new InvalidTwoFACodeException;
    }

    public function isTwoFaVerfied(?string $session_id = null): bool
    {
        $session_id = $session_id ?? request()->session()->getId();

        return $this->twoFaVerifis()->where('session_id', $session_id)->exists();
    }
}
