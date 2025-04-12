<x-mail::message>
# Greetings,

Thank you for registering with us! To complete your registration, please verify your email address by clicking the button below.

<x-mail::button :url="$verifyUrl">
Verify Email
</x-mail::button>

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
