@extends('layout')

@section('content')

    <div class="backButton">
        <h1>
            <a href="/">
                <button class="btn btn-success">Back to Form</button>
            </a>
        </h1>
    </div>

    <div id="app">
        <admin-page></admin-page>
    </div>

@endsection
