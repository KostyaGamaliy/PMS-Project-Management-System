@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded">
        <div class="lead">
            Edit participant
        </div>

        <div class="container mt-4 p-0">
            <form method="POST" action="{{ route('admin.project.members.update', ['project' => $project]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $user->name }}"
                           type="text"
                           class="form-control shadow-none @error('name') is-invalid @enderror"
                           name="name"
                           disabled
                    >
                </div>

                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="role_id" class="form-label">Role</label>
                    <select class="form-select shadow-none @error('role_id') is-invalid @enderror"
                            name="role_id"
                            id="inputRole">
                        @foreach($roles as $role)
                            <option
                                value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : ''}}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                @error('role_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3" id="permissions-select"></div>

                <button type="submit" class="btn btn-outline-primary shadow-none">Update table</button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        window.onload = function () {
            $('#inputRole').change(function (e) {
                axios.post('{{ route('admin.project.members.getPermissions') }}', {
                    'role_id': document.getElementById('inputRole').value
                })
                    .then(function (response) {
                        console.log(response.data);

                        var permissionsdiv = document.getElementById('permissions-select');
                        var html = `<label for="permission_id" class="form-label">Permissions</label>
                            <select class="form-select shadow-none @error('permission_id') is-invalid @enderror"
                            name="permission_id"
                            id="inputPermission"
                            multiple
                            disabled
                            name="permissions[]">`;
                        for (var i = 0; i < response.data.length; i++) {
                            var permission = response.data[i];
                            html += `<option value="${permission.id}" ${permission.selected ? 'selected' : ''}>${permission.description}</option>`;
                        }
                        html += `</select>`;
                        permissionsdiv.innerHTML = html;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            })
        }
    </script>
@endsection
