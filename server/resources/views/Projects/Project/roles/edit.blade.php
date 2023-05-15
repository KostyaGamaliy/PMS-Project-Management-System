@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded">
        <div class="lead">
            Edit role
        </div>

        <div class="container mt-4 p-0">
            <form method="POST" action="{{ route('admin.project.roles.update', ['project' => $project]) }}"
                  enctype="multipart/form-data">
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

                <button type="submit" class="btn btn-primary">Update role</button>
            </form>
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
