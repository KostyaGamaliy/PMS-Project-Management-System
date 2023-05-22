<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Project PDF</title>
    <style>
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="d-flex flex-column align-items-center">
    <div class="center">
        <h1>Project Name: {{ $project->name }}</h1>
    </div>
    <div class="center">
        <h1>Project Description: {{ $project->descriptions }}</h1>
    </div>
</div>

@foreach($project->dashboards as $dashboard)
    <h2>Dashboard: {{ $dashboard->name }}</h2>
    @if(isset($dashboard->tasks) && count($dashboard->tasks) > 0)
        @foreach($dashboard->tasks as $task)
            <div>
                <h3>Task name: {{$task->name}}</h3>
                <h3>Task status: {{$task->status}}</h3>
                @if (strtolower($task->status) !== 'done')
                    @php
                        $task->load('user');
                        $startedDate = Carbon\Carbon::parse($task->created_at)->format('d-m-Y');

						$role = \App\Models\Role::where('user_id', $task->user->id)->where('project_id', $project->id)->first();
                    @endphp
                    <h3>When the task was created: {{ $startedDate }} for {{ $task->user->name }} ({{ $role->name }})</h3>
                    <br>
                @endif
                @if(strtolower($task->status) === 'done')
                    @php
                        $task->load('user');
                        $finishedDate = Carbon\Carbon::parse($task->updated_at)->format('d-m-Y');

						$role = \App\Models\Role::where('user_id', $task->user->id)->where('project_id', $project->id)->first();
                    @endphp
                    <h3>When the task was finished: {{ $finishedDate }} by {{ $task->user->name }} ({{ $role->name }})</h3>
                    <br>
                @endif
            </div>
        @endforeach
    @else
        <div class="center"><h3>Not a single task was found</h3></div>
    @endif
@endforeach
</body>
</html>
