@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded" id="mainPageForReloadData">
        <div class="lead">
            Add a participant to the project
        </div>

        <div class="container mt-4 p-0">
            <form method="POST"
                  action="{{ route('admin.project.members.store', ['project' => $project]) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="user_id" class="form-label">Select user</label>
                    <select class="form-select shadow-none @error('user_id') is-invalid @enderror"
                            name="user_id"
                            id="inputUser">
                        @foreach($users as $user)
                            <option
                                value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                @error('user_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="role_id" class="form-label">Select role</label>
                    <select class="form-select shadow-none @error('role_id') is-invalid @enderror"
                            name="role_id"
                            id="inputRole">
                        @foreach($roles as $role)
                            <option
                                value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : ''}}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                @error('role_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-outline-primary shadow-none">Add</button>

            </form>
        </div>
    </div>
@endsection
