<?php

namespace Solutionforest\FilamentEmail2fa\Middlewares;
use Illuminate\Http\Request;
use Closure;
use Filament\Facades\Filament;

class IsTwoFAVerified{

    public function handle(Request $request, Closure $next): Response
    {
        $user = Filament::auth()->user();
        if($user == null){
            return $next($request);
        }


        if ($user->isTwoFaVerfied($request->session()->getId())) {

            return $next($request);

        }

        return abort(404);
    }
}
