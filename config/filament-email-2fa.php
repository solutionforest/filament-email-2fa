<?php

// config for Solutionforest/FilamentEmail2fa
return [
    // The name of the table where the 2FA codes will be stored
    'code_table' => 'filament_email_2fa_codes',

    // The name of the table where 2FA verifications will be stored
    'verify_table' => 'filament_email_2fa_verify',

    // The model class used for the 2FA codes
    'code_model' => \Solutionforest\FilamentEmail2fa\Models\TwoFaCode::class,

    // The model class used for 2FA verifications
    'verify_model' => \Solutionforest\FilamentEmail2fa\Models\TwoFaVerify::class,

    // The time in minutes before the 2FA code expires
    // This defines how long a 2FA code is valid after it is generated
    'expiry_time_by_mins' => 10,

    // The page class responsible for handling the 2FA verification process
    // Customize this if you have a different 2FA page implementation
    '2fa_page' => \Solutionforest\FilamentEmail2fa\Pages\TwoFactorAuth::class,

    // The page class that is shown after a successful login with 2FA
    // This can be customized to redirect users to a specific page after they pass 2FA
    'login_success_page' => \Solutionforest\FilamentEmail2fa\Pages\LoginSuccessPage::class,

    // The morph name used for polymorphic relationships
    // Default is 'user', change to 'admin' if using with admin models
    'morph_name' => 'user',
];
