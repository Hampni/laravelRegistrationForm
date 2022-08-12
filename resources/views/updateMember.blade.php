@extends('layout')

@section('content')

    <div class="backButton">
        <h1>
            <a href="/adminPanel">
                <button class="btn btn-info">Back to Admin Panel</button>
            </a>
        </h1>
    </div>

    <div id="app">
        <update-page :id='@json($id)'></update-page>
    </div>



@endsection
