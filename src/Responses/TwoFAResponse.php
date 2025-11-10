<?php

namespace Solutionforest\FilamentEmail2fa\Responses;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Filament\Facades\Filament;
use Solutionforest\FilamentEmail2fa\Pages\TwoFactorAuth;

class TwoFAResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // return whatever you want as url

        if (Filament::getPanel()->hasPlugin('filament-email-2fa')) {
            Filament::auth()->user()->send2FAEmail();

            return redirect()->intended(route(TwoFactorAuth::getRouteName()));
        }

        return redirect()->intended(Filament::getUrl());

    }
}
