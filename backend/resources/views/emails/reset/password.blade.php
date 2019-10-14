@component('mail::message')
Pour modifier votre Mot de passe s il vous plait cliquer sur le liens se dessous
@component('mail::button', ['url' => 'http://localhost:4200/response_password_reset?token='.$token])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
