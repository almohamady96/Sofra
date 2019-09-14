@component('mail::message')
# Introduction

bloodbank reset password.
<p>hello {{$user->name}}</p>
<p> your reset password is : {{$user->pin_code}}</p>
{{--
@component('mail::button', ['url' => 'http://ayman_hassan1195@yahoo.com','color'=>'success'])
    reset
@endcomponent
--}}
Thanks,<br>
{{ config('app.name') }}
@endcomponent
