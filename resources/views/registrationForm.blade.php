@extends('layout')

@section('content')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v14.0"
            nonce="GGjbTgqU"></script>

    {{--Google chart--}}
    <div class="chart-align">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3303.7615498731893!2d-118.34587228458561!3d34.1012485
22592996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2bf20e4c82873%3A0x14015754d926dadb!2zNzA2MCBIb2xseXdvb2Q
gQmx2ZCwgTG9zIEFuZ2VsZXMsIENBIDkwMDI4LCDQodCo0JA!5e0!3m2!1sru!2slt!4v1658219330371!5m2!1sru!2slt"
                style="border:0; width: 100%; height: 450px" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    {{--Authorisation as admin--}}

    <!--Admin is logged in-->
    @auth

        <div>
            <div class="divRF">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <button class="btn btn-info">{{ __('Logout') }}</button>
                </a>
            </div>
            <div class="divRF">
                <a href="/adminPanel">
                    <button class="btn btn-info">{{ __('Admin Panel') }}</button>
                </a>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @else
        <!--admin is NOT logged in-->
        <a href="{{ route('login') }}">
            <button class="btn btn-info">Login as admin</button>
        </a>
    @endauth


    <div id="app">
        <form-page></form-page>
    </div>

@endsection
