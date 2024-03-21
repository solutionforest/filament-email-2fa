<?php

namespace Solutionforest\FilamentEmail2fa\Interfaces;

use Illuminate\Database\Eloquent\Relations\Relation;

interface RequireTwoFALogin
{
    public function twoFaCodes(): Relation;

    public function twoFaVerifis(): Relation;

    public function latest_2fa_code(): Relation;

    public function generate2FACode(): string;

    public function verify2FACode(string $code);

    public function isTwoFaVerfied(?string $session_id = null): bool;
}
