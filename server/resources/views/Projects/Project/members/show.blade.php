@extends('layouts.project-dashboard')

@section('project')

    <div id="content">
        <div class="container-fluid my-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <h3 class="h3 mb-0 text-gray-800">{{ $dashboard->name }}</h3>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Add task</a>
            </div>
            <div class="rounded-1">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Info</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td><button class="btn btn-success">EDIT</button></td>
                        <td><button class="btn btn-danger">DELETE</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
