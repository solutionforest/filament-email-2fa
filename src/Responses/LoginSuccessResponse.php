<?php

namespace Solutionforest\FilamentEmail2fa\Responses;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

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
        $page = Filament::getCurrentPanel()->getPlugin('filament-email-2fa')->getLoginSuccessPage();

        return redirect()->intended(route($page::getRouteName()));
    }
}
