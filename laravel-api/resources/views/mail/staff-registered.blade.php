<x-mail::message>
# Greetings,

You have been granted access to {{ env('APP_NAME') }}. Below are your login credentials:

## Username: {{ $username }}
## Password: {{ $password }}

Once logged in, we recommend you change your password to something more personal for added security. If you have any issues with logging in or need assistance, please contact our IT support team at <b>[Support Email]</b>.

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

Thanks,<br>
{{ env('MAIL_FROM_NAME') }} Team
</x-mail::message>
