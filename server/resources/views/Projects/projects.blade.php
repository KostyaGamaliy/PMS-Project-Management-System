@extends('layouts.app')

@section('content')

    <div class="container p-4">
        <div class="search d-flex align-items-center">
            <input type="text" class="form-control me-2 flex-grow-1" placeholder="Have a question? Ask Now">
            <button class="btn btn-primary me-2">Search</button>
            <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProjectModal">Create project</a>
        </div>

        <div class="container d-flex justify-content-evenly  flex-wrap ">
            @foreach($projects as $project)
                <div class="card my-1" style="width: 18rem;">
                    <a href="{{ route('home.show', ['id' => $project->id]) }}">
                        <img  src="{{ url('storage/' . ($project->preview_image ??  $default)) }}" class="card-img-top" style="width: 286px; height: 10rem" alt="none image">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $project->name }}</h5>
                        <p class="card-text text-truncate">{{ $project->descriptions }}</p>
                    </div>
                    <div class="d-flex justify-content-around pb-3">
                        <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                           data-bs-target="#updateProjectModal{{ $project->id }}">Edit</a>

                        <form action="{{ route('home.deleteProject', ['id' => $project->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @foreach($projects as $project)
            <div>
                @include('Projects.updateProject')
            </div>
        @endforeach

        <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModal"
             aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="{{ route('home.createProject') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id ?? ""}}">

                    <div class="modal-header">
                        <h5 class="modal-title">Create your project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input
                            class="form-control mb-3"
                            type="text"
                            placeholder="Name of project"
                            name="name"
                            value="{{ old('name') }}"
                            class="@error('name') is-invalid @enderror"
                        >
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input
                            class="form-control mb-3"
                            type="text"
                            placeholder="Descriptions"
                            name="descriptions"
                            value="{{ old('descriptions') }}"
                            class="@error('descriptions') is-invalid @enderror"
                        >
                        @error('descriptions')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input
                            class="form-control"
                            type="file"
                            name="preview_image"
                            value="{{ old('preview_image') }}"
                            class="@error('preview_image') is-invalid @enderror"
                        >
                        @error('preview_image')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
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
                url: '{{ route('home.updateLastModal') }}',
                type: 'POST',
                data: {
                    modal_id: modal_id,
                    _token: '{{ csrf_token() }}'
                }
            });
        });
    </script>


@endsection
