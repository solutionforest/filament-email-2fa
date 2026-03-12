<?php

namespace Solutionforest\FilamentEmail2fa\Responses;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Solutionforest\FilamentEmail2fa\Pages\TwoFactorAuth;
use Symfony\Component\HttpFoundation\Response;

class TwoFAResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  Request  $request
     * @return Response
     */
    public function toResponse($request)
    {
        // return whatever you want as url

        if (Filament::getCurrentPanel()->hasPlugin('filament-email-2fa')) {
            Filament::auth()->user()?->send2FAEmail();

            return redirect()->intended(route(TwoFactorAuth::getRouteName()));
        }

        return redirect()->intended(Filament::getUrl());
    }
}
