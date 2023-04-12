@extends('layouts.app')


@section('content')
    <div class="container py-3">
        <div class="search d-flex align-items-center">
            <a class="btn btn-primary" href="{{ route('home.projects.index') }}">My projects</a>
        </div>
    </div>
@endsection
