@extends('layout')

@section('content')

    <div id="app">
        <update-page :id='@json($id)'></update-page>
    </div>

@endsection
