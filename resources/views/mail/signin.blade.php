@component('mail::message')
    @component('mail::button', ['url' => $url])
        Klick hier um dich anzumelden ✨
    @endcomponent

    Dieser Link ist nur für  30 Minuten gültig.

@endcomponent
