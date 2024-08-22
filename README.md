# filament-email-2fa

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solution-forest/filament-email-2fa.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-email-2fa)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/solution-forest/filament-email-2fa/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/solution-forest/filament-email-2fa/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/solution-forest/filament-email-2fa/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/solution-forest/filament-email-2fa/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solution-forest/filament-email-2fa.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-email-2fa)


## Secure Your Filament Applications with Email-Based 2FA

This package seamlessly integrates two-factor authentication (2FA) into your Filament PHP applications using email verification codes. Enhance the security of your user accounts and protect sensitive data.

![image](https://github.com/solutionforest/filament-email-2fa/assets/68211972/8fcefe16-c280-41f0-bc26-652f285b8975)


### Key Features:

- Easy Integration: Quickly add 2FA to your Filament projects with minimal configuration.
- Email Verification: Users receive time-sensitive codes via email for secure login.
- Customizable: Tailor the 2FA experience with configurable options (e.g., code expiry time).
- Seamless User Experience: Provides a user-friendly interface for setting up and using 2FA.
- Email Two-Factor Authentication Button: Utilize the `EmailTwoFaButtonAction` to add a button for email-based 2FA in your Filament forms.

### How it Works:

- Upon successful login, users are prompted to enter a verification code sent to their email address.
- The package handles code generation, email delivery, and verification logic.
- Once verified, users gain access to the protected Filament panel.

### Ideal For:

Filament applications handling sensitive user data.
Projects requiring an extra layer of account security.
Developers seeking a straightforward 2FA solution.


## Installation

You can install the package via composer:

```bash
composer require solution-forest/filament-email-2fa
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-email-2fa-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-email-2fa-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-email-2fa-views"
```

This is the contents of the published config file:

```php
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
```

## Adding the plugin to a panel

```php
use Solutionforest\FilamentEmail2fa\FilamentEmail2faPlugin;

return $panel
        // ...
        ->plugin(FilamentEmail2faPlugin::make());
```

## Preparing your filament user class

Implement the 'RequireTwoFALogin' interface and use the 'HasTwoFALogin' trait

```php
use Solutionforest\FilamentEmail2fa\Interfaces\RequireTwoFALogin;
use Solutionforest\FilamentEmail2fa\Trait\HasTwoFALogin;

class FilamentUser extends Authenticatable implements FilamentUserContract,RequireTwoFALogin{
    use HasTwoFALogin;
}
```

## Using the EmailTwoFaButtonAction

To add the `EmailTwoFaButtonAction` to a Filament form, follow these steps:

1. **Add the Action to Your Form:**

   ```php
   use Solutionforest\FilamentEmail2fa\Actions\EmailTwoFaButtonAction;

   // In your Filament form setup
   $form->actions([
       EmailTwoFaButtonAction::make()
           ->label(__('Send 2FA Code'))
           ->color('primary'),
   ]);
   ```

3. **Handle 2FA Code Verification:**

   The action will prompt the user to enter the 2FA code sent to their email. It will handle code validation and notify the user of success or failure.

## Customizing the 2FA Email Class

You can use a custom email class when sending the 2FA email. By default, the `Solutionforest\FilamentEmail2fa\Mail\TwoFAEmail` class is used, but you can specify a different class if needed.

### Example of Using a Custom Email Class

You can specify a custom email class for sending 2FA emails by configuring the plugin. 

### Define a Custom Email Class

Create a custom email class extending `Mailable`:

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomTwoFAEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $code;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $code
     */
    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Custom 2FA Code')
                    ->markdown('emails.custom_twofa', ['name' => $this->name, 'code' => $this->code]);
    }
}
```

In the `resources/views/emails/custom_twofa.blade.php` file:

Update the plugin’s configuration file (`config/filament-email-2fa.php`) to use your custom email class:

```php
/*
|--------------------------------------------------------------------------
| Custom 2FA Email Class
|--------------------------------------------------------------------------
|
| Specify the custom email class used for sending 2FA emails.
| This class should extend \Illuminate\Mail\Mailable and define
| the email content and format.
|
*/
'email_class' => \App\Mail\CustomTwoFAEmail::class,
```
