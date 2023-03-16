@extends('layouts.app')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

@section('content')
    <div class="container">
        <div class="search d-flex align-items-center">
            <a class="btn btn-primary" href="{{ route('home.projects') }}">My projects</a>
        </div>
    </div>
@endsection
