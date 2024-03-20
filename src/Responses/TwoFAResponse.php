<?php

namespace Solutionforest\FilamentEmail2fa\Responses;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class TwoFAResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // return whatever you want as url
        $guard = Filament::getCurrentPanel()->getAuthGuard();
        $url = route("filament.{$guard}.pages.sf-filament-2fa.2sv");

        return redirect()->intended($url);
    }
}
