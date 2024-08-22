@component('mail::message')
# Hi {{ $name }},

Your 2FA code is:

<x-mail::panel>
**{{ $code }}**
</x-mail::panel>

This code will expire in {{ config('filament-email-2fa.expiry_time_by_mins', 10) }} minutes.

Please enter this code on the verification page to complete the process. If you did not request this code, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
