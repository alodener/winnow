@component('mail::message')
## Olá {{$data['name']}}

# {{$data['message']}}

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
