<?php

// config for Solutionforest/FilamentEmail2fa
return [
    'table'=>'filament_email_2fa_codes',
    'model'=>\Solutionforest\FilamentEmail2fa\Models\TwoFaCode::class,
    'expiry_time_by_mins'=>10

];
