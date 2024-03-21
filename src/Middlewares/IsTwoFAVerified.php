<?php

namespace Solutionforest\FilamentEmail2fa\Middlewares;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Solutionforest\FilamentEmail2fa\Interfaces\RequireTwoFALogin;

class IsTwoFAVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Filament::auth()->user();
        if ($user == null) {
            return $next($request);
        }

        if ($user instanceof RequireTwoFALogin && $user->isTwoFaVerfied($request->session()->getId())) {

            return $next($request);

        }

        return abort(404);
    }
}
