@extends('layouts.project-dashboard')

@section('project')

    <div id="content">
        <div class="container-fluid my-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">People working on the project</h1>
                <a href="{{ route('admin.project.members.create', ['project' => $project]) }}"
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i>Add a participant to the project</a>
            </div>
            <div class="rounded-1">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">Name</th>
                        <th scope="col" class="text-center">Role</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($project->users as $user)

                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td class="text-center">{{ $user->name }}</td>
                            @foreach($project->roles as $projectRole)
                                @if($projectRole->user_id == $user->id)
                                    <td class="text-center">{{ $projectRole->name }}</td>
                                @endif
                            @endforeach
                            <td>
                                <form method="GET" class="text-center"
                                      action="{{ route('admin.project.members.edit', ['project' => $project, 'user' => $user]) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <button class="btn btn-success" type="submit">
                                        EDIT
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                @if(Auth::user()->id !== $user->id)
                                    <a type="button" class="btn btn-danger" onclick="return confirm('Are you sure?')"
                                       href="{{ route('admin.project.members.destroy', ['project' => $project, 'user' => $user]) }}">Remove
                                        from the project</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
