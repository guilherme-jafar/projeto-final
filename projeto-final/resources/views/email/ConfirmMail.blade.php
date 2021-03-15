@component('mail::message')
# Introduction

Para confirmar o registo da sua conta basta clicar no botão

@component('mail::button', ['url' => $ticket])
Confirmar conta
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
