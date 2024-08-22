<?php

namespace Solutionforest\FilamentEmail2fa\Interfaces;

use Illuminate\Database\Eloquent\Relations\Relation;

interface RequireTwoFALogin
{
    public function twoFaCodes(): Relation;

    public function twoFaVerifications(): Relation;

    public function latest2faCode(): Relation;

    public function generate2FACode(): string;

    public function verify2FACode(string $code);

    public function isTwoFaVerified(?string $session_id = null): bool;
}
