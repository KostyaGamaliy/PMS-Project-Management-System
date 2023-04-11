@extends('layouts.project-dashboard')

@section('project')

    <div id="content">
        <div class="container-fluid my-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Roles</h1>
                <a href="{{ route('home.project.roles.create', ['project' => $project]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>Add a role
                </a>
            </div>
            <div class="rounded-1">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">Name</th>
                        <th scope="col" class="text-center">Info</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <th scope="row">{{ $role->id }}</th>
                            <td class="text-center">{{ $role->name }}</td>
                            <td class="text-center">
                                <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                   data-bs-target="#infoPeopleRole{{$role->id}}">INFO</a>
                            </td>
                            <td>
                                <form method="GET" class="text-center" action="{{ route('home.project.roles.edit', ['project' => $project, 'role' => $role]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <button class="btn btn-success" type="submit">
                                        EDIT
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <a type="button" class="btn btn-danger" href="{{ route('home.project.roles.destroy', ['project' => $project, 'role' => $role]) }}">Delete</a>
                            </td>
                        </tr>

                        <div class="modal fade" id="infoPeopleRole{{$role->id}}" tabindex="-1" aria-labelledby="infoPeopleRole{{$role->id}}"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Info</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Role:</h4>
                                            </div>
                                            <div class="col-8">
                                                <h3>{{ $role->name }}</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Role permissions:</h4>
                                            </div>
                                            <div class="col-8">
                                                @foreach($role->permissions as $permission)
                                                    <h3>{{ $permission->description }}</h3>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
