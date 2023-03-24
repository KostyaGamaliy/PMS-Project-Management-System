@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded">
        <div class="lead">
            Add new task
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container mt-4 p-0">
            <form method="POST"
                  action="{{ route('home.project.dashboard.task.store', ['project' => $project, 'dashboard' => $dashboard]) }}"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ Auth::user()->id }}" name="assigner_id">
                <input type="hidden" value="{{ $dashboard->id }}" name="dashboard_id">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}"
                           type="text"
                           class="form-control shadow-none @error('name') is-invalid @enderror"
                           name="name"
                           placeholder="Name" required>
                </div>

                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input value="{{ old('description') }}"
                           type="text"
                           class="form-control shadow-none @error('description') is-invalid @enderror"
                           name="description"
                           placeholder="Description">
                </div>

                @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="user_id" class="form-label">Select who will be doing this task</label>
                    <select class="form-select shadow-none @error('user_id') is-invalid @enderror"
                            name="user_id"
                            id="inputGroupSelect01">
                        <option selected>Select user</option>
                        @foreach($project->users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->name ? 'selected' : ''}}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                @error('user_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-outline-primary shadow-none">Create table</button>
            </form>
        </div>

    </div>
@endsection
