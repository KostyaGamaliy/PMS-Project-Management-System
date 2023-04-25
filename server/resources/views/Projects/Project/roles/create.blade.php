@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded" id="mainPageForReloadData">
        <div class="lead">
            Add a role
        </div>

        <div class="container mt-4 p-0">
            <form method="POST"
                  action="{{ route('admin.project.roles.store', ['project' => $project]) }}"
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

                <button type="submit" class="btn btn-primary shadow-none">Add role</button>
                <a type="button" class="btn btn-outline-primary shadow-none" data-bs-toggle="modal"
                   data-bs-target="#addPermissionModal">Add permission</a>
                <a type="button" class="btn btn-outline-danger shadow-none" data-bs-toggle="modal"
                   data-bs-target="#deletePermissionModal">Delete permissions</a>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.permission.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Add new permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input
                            class="form-control"
                            type="text"
                            placeholder="Description of permission"
                            name="description"
                            value="{{ old('description') }}"
                            class="@error('description') is-invalid @enderror"
                        >

                        @error('description')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add permission</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.permission.destroy') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Delete permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <label for="permission_id" class="form-label">Select the permissions to delete</label>
                        <select class="form-select shadow-none @error('permission_id') is-invalid @enderror"
                                name="permission_id[]"
                                id="inputPermission"
                                multiple
                        >
                            @foreach($permissions as $permission)
                                <option
                                    value="{{ $permission->id }}" {{ in_array( $permission->id, old('permission_id', []))  ? 'selected' : ''}}>{{ $permission->description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Delete permissions</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        $last_modal = session('last_modal');
    @endphp

    <script>
        $(document).ready(function () {
            @if ($errors->any())
            var last_modal = '{{ $last_modal }}';
            if (last_modal) {
                $('#' + last_modal).modal('show');
            } else {
                $('#createProjectModal').modal('show');
            }
            @endif
        });

        $('.modal').on('shown.bs.modal', function () {
            var modal_id = $(this).attr('id');
            $.ajax({
                url: '{{ route('admin.updateLastModal') }}',
                type: 'POST',
                data: {
                    modal_id: modal_id,
                    _token: '{{ csrf_token() }}'
                }
            });
        });
    </script>
@endsection
