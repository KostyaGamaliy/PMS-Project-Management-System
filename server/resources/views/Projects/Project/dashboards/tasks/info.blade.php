@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded">
        <div class="lead">
            Task info
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <h4>Name</h4>
                    <p>{{ $task->name }}</p>
                </div>

                <div class="col-md-6">
                    <h4>Status</h4>
                    <p>{{ $task->status }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Description</h4>
                    <p>{{ $task->description }}</p>
                </div>

                <div class="col-md-6">
                    <h4>Who working on this task</h4>
                    <p>{{ $task->user->name }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
