@component('mail::message')

Hello {{ $name }} <br>
Thanks for the registration to the conference

@component('mail::button', ['url' => 'http://google.com'])
    Click here
@endcomponent

@endcomponent

