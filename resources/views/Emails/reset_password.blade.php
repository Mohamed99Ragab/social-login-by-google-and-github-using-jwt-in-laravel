@component('mail::message')
# Change Password

can you click button in below to change your password to this email.
{{$email}}

@component('mail::button', ['url' => 'http://127.0.0.1:8000/api/auth/reset_password?token='.$token])
Rest Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
