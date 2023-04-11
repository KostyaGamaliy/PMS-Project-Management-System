@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded">
        <div class="lead">
            Edit role
        </div>

        <div class="container mt-4 p-0">
            <form method="POST" action="{{ route('home.project.roles.update', ['project' => $project]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="role_id" value="{{ $role->id }}">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $role->name }}"
                           type="text"
                           class="form-control shadow-none @error('name') is-invalid @enderror"
                           name="name"
                    >
                </div>

                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label class="form-label" for="permission_id">Permissions</label>
                    <select class="form-select" multiple name="permission_id[]">
                        <option disabled>Select permissions</option>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}" {{ in_array( $permission->id, old('permissions', $selectedRole))  ? 'selected' : ''}}>{{ $permission->description }}</option>
                        @endforeach
                    </select>
                </div>

                @error('permission_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-outline-primary shadow-none">Update role</button>
            </form>
        </div>
    </div>
@endsection
