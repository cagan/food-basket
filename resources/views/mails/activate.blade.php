@component('mail::message')
# Account Confirmation

Hi {{ $user->name }},

Thanks for signup! Please before you begin, you must confirm your account!

@component('mail::button', ['url' => $url])
    Confirm Your Account
@endcomponent

Thank you for sign up!,<br>
{{ config('app.name') }}
@endcomponent
