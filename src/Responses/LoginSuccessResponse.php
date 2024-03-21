<?php

namespace Solutionforest\FilamentEmail2fa\Responses;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Solutionforest\FilamentEmail2fa\Pages\LoginSuccessPage;

class LoginSuccessResponse implements LoginResponseContract
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


        return redirect()->intended(route(LoginSuccessPage::getRouteName()));
    }
}
