@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded">
        <div class="lead">
            Edit table
        </div>

        <div class="container mt-4 p-0">
            <form method="POST" action="{{ route('admin.project.dashboard.update', ['project' => $project, 'dashboard' => $dashboard]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name', $dashboard->name) }}"
                           type="text"
                           class="form-control shadow-none @error('name') is-invalid @enderror"
                           name="name"
                           placeholder="Name" required>
                </div>

                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-outline-primary shadow-none">Update table</button>
            </form>
        </div>

    </div>
@endsection
