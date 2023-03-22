@extends('layouts.app')


@section('content')
    <div class="container py-3">
        <div class="search d-flex align-items-center">
            <a class="btn btn-primary" href="{{ route('home.projects') }}">My projects</a>
        </div>
    </div>
@endsection
