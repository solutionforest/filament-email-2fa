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
    'code_table' => 'filament_email_2fa_codes',
    'verify_table' => 'filament_email_2fa_verify',

    'code_model' => \Solutionforest\FilamentEmail2fa\Models\TwoFaCode::class,
    'verify_model' => \Solutionforest\FilamentEmail2fa\Models\TwoFaVerify::class,

    'expiry_time_by_mins' => 10,

    '2fa_page' => \Solutionforest\FilamentEmail2fa\Pages\TwoFactorAuth::class,
    'login_success_page' => \Solutionforest\FilamentEmail2fa\Pages\LoginSuccessPage::class,
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

