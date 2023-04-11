@extends('layouts.project-dashboard')

@section('project')

    <div id="content">
        <div class="container-fluid my-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Roles for this project</h1>
                <a href=""
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i>Add a role</a>
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
                                <form method="GET" class="text-center" action="" enctype="multipart/form-data">
                                    @csrf
                                    <button class="btn btn-success" type="submit">
                                        EDIT
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <a type="button" class="btn btn-danger" href="">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
