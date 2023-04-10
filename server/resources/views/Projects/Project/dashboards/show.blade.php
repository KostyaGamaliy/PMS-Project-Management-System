@extends('layouts.project-dashboard')

@section('project')

    <div id="content">
        <div class="container-fluid my-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <h3 class="h3 mb-0 text-gray-800">{{ $dashboard->name }}</h3>
                <div class="d-flex flex-row justify-content-around shadow-sm">
                    <a href="{{ route('home.project.dashboard.task.create', ['project' => $project, 'dashboard' => $dashboard]) }}"
                       class="btn btn-sm btn-primary"><i
                            class="fas fa-download fa-sm text-white-50"></i> Add task</a>
                    <form class="mx-2" method="GET"
                          action="{{ route('home.project.dashboard.edit', ['project' => $project, 'dashboard' => $dashboard]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <button class="btn btn-sm btn-success">
                            Edit table
                        </button>
                    </form>
                    <form method="POST"
                          action="{{ route('home.project.dashboard.destroy', ['project' => $project, 'dashboard' => $dashboard]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            Delete table
                        </button>
                    </form>
                </div>
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
                    @foreach($dashboard->tasks as $task)
                        <tr>
                            <th scope="row">{{ $task->id }}</th>
                            <td class="text-center">{{ $task->name }}</td>
                            <td class="text-center">{{ $task->status }}</td>
                            <td>
                                <form method="GET" class="text-center" action="{{ route('home.project.dashboard.task.show', ['project' => $project, 'dashboard' => $dashboard, 'task' => $task]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <button class="btn btn-info" type="submit">
                                        INFO
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="GET" class="text-center" action="{{ route('home.project.dashboard.task.edit', ['project' => $project, 'dashboard' => $dashboard, 'task' => $task]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <button class="btn btn-success" type="submit">
                                        EDIT
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" class="text-center" action="{{ route('home.project.dashboard.task.destroy', ['project' => $project, 'dashboard' => $dashboard, 'task' => $task]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        DELETE
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
