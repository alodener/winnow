@component('mail::message')
# Bem-vindo {{$user->name}}

## Você fez uma ótima escolha nos escolhendo, e nós tomamos uma maravilhosa decisão te aceitando em nosso time! Seja bem-vindo.

Att,<br>
{{ config('app.name') }}
@endcomponent
