@component('mail::message')
# Olá {{$data['name']}}

## {{$data['message']}}

Att,<br>
{{ config('app.name') }}
@endcomponent
