@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot


    @component('mail::button', ['url' => $url])
        Klick hier um dich anzumelden ✨
    @endcomponent

    Dieser Link ist nur für  30 Minuten gültig.

@endcomponent
