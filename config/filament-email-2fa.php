<?php

// config for Solutionforest/FilamentEmail2fa
return [
    'code_table' => 'filament_email_2fa_codes',
    'verify_table' => 'filament_email_2fa_verify',

    'code_model' => \Solutionforest\FilamentEmail2fa\Models\TwoFaCode::class,
    'verify_model' => \Solutionforest\FilamentEmail2fa\Models\TwoFaVerify::class,

    'expiry_time_by_mins' => 10,

    'auth_model' => env('AUTH_MODEL', App\Models\User::class),
    
    '2fa_page' => \Solutionforest\FilamentEmail2fa\Pages\TwoFactorAuth::class,
    'login_success_page' => \Solutionforest\FilamentEmail2fa\Pages\LoginSuccessPage::class,

];
