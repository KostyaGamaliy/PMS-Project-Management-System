@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded" id="mainPageForReloadData">
        <div class="lead">
            Add a participant to the project
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

                <div class="mb-3" id="permissions-select"></div>

                <button type="submit" class="btn btn-outline-primary shadow-none">Add</button>

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
