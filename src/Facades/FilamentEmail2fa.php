<?php

namespace Solutionforest\FilamentEmail2fa\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Solutionforest\FilamentEmail2fa\FilamentEmail2fa
 */
class FilamentEmail2fa extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Solutionforest\FilamentEmail2fa\FilamentEmail2fa::class;
    }
}
