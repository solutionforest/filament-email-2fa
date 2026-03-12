<?php

namespace Solutionforest\FilamentEmail2fa\Responses;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginSuccessResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  Request  $request
     * @return Response
     */
    public function toResponse($request)
    {
        $page = Filament::getCurrentPanel()->getPlugin('filament-email-2fa')->getLoginSuccessPage();

        return redirect()->intended(route($page::getRouteName()));
    }
}
