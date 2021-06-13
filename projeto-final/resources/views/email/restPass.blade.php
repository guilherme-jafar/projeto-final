@component('mail::message')
# Introduction

Voce quer alterar a password da sua conta

@component('mail::button', ['url' => $ticket])
resetar a password
@endcomponent

Com os devidos comprimentos,<br>
{{ config('app.name') }}
@endcomponent
