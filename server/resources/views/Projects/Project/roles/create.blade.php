@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded" id="mainPageForReloadData">
        <div class="lead">
            Add a role
        </div>

        <div class="container mt-4 p-0">
            <form method="POST"
                  action="{{ route('home.project.roles.store', ['project' => $project]) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}"
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
                            <option
                                value="{{ $permission->id }}" {{ in_array( $permission->id, old('permissions', []))  ? 'selected' : ''}}>{{ $permission->description }}</option>
                        @endforeach
                    </select>
                </div>

                @error('permission_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-outline-primary shadow-none">Add</button>

            </form>
        </div>
    </div>
@endsection
