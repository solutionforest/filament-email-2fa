<?php

// config for Solutionforest/FilamentEmail2fa
return [
    /*
    |--------------------------------------------------------------------------
    | 2FA Code Table
    |--------------------------------------------------------------------------
    |
    | The name of the table where the 2FA codes will be stored.
    |
    */
    'code_table' => 'filament_email_2fa_codes',

    /*
    |--------------------------------------------------------------------------
    | 2FA Verification Table
    |--------------------------------------------------------------------------
    |
    | The name of the table where 2FA verifications will be stored.
    |
    */
    'verify_table' => 'filament_email_2fa_verify',

    /*
    |--------------------------------------------------------------------------
    | 2FA Code Model
    |--------------------------------------------------------------------------
    |
    | The model class used for the 2FA codes.
    |
    */
    'code_model' => \Solutionforest\FilamentEmail2fa\Models\TwoFaCode::class,

    /*
    |--------------------------------------------------------------------------
    | 2FA Verification Model
    |--------------------------------------------------------------------------
    |
    | The model class used for 2FA verifications.
    |
    */
    'verify_model' => \Solutionforest\FilamentEmail2fa\Models\TwoFaVerify::class,

    /*
    |--------------------------------------------------------------------------
    | 2FA Code Expiry Time
    |--------------------------------------------------------------------------
    |
    | The time in minutes before the 2FA code expires.
    |
    */
    'expiry_time_by_mins' => 10,

    /*
    |--------------------------------------------------------------------------
    | 2FA Page
    |--------------------------------------------------------------------------
    |
    | The page class responsible for handling the 2FA verification process.
    |
    */
    '2fa_page' => \Solutionforest\FilamentEmail2fa\Pages\TwoFactorAuth::class,

    /*
    |--------------------------------------------------------------------------
    | Login Success Page
    |--------------------------------------------------------------------------
    |
    | The page class that is shown after a successful login with 2FA.
    |
    */
    'login_success_page' => \Solutionforest\FilamentEmail2fa\Pages\LoginSuccessPage::class,

    /*
    |--------------------------------------------------------------------------
    | 2FA Email Class
    |--------------------------------------------------------------------------
    |
    | Specify the custom email class used for sending 2FA emails.
    | This class should extend \Illuminate\Mail\Mailable and define
    | the email content and format.
    |
    */
    'email_class' => \Solutionforest\FilamentEmail2fa\Mail\TwoFAEmail::class,
];
