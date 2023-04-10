@extends('layouts.project-dashboard')

@section('project')

    <div id="content">
        <div class="container-fluid my-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">People working on the project</h1>
                <h3 class="h3 mb-0 text-gray-800">{{ $dashboard->name }}</h3>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i>Add a participant to the project</a>
            </div>
            <div class="rounded-1">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">Name</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Info</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($project->users as $user)

                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->role->name }}</td>
                            <td class="text-center">
                                <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                   data-bs-target="#infoPeopleRole{{$user->id}}">INFO</a>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-success">EDIT</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger">Remove from the project</button>
                            </td>
                        </tr>

                        <div class="modal fade" id="infoPeopleRole{{$user->id}}" tabindex="-1" aria-labelledby="infoPeopleRole{{$user->id}}"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Info</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h3>{{ $user->name }}</h3>
                                        <h3>{{ $user->role->name }}</h3>
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
