<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>About project</title>
</head>
<body>
<h1>My PDF-file about project</h1>
<div><h3>Name:</h3> {{ $project->name }}</div>
<div><h3>Description:</h3> {{ $project->descriptions }}</div>
<div>
    <h3>Users on this project:</h3>
    @foreach($project->users as $user)
        {{ $user->name }}
        @foreach($project->roles as $role)
            @if($role->user_id === $user->id)
                ( role: {{$role->name}} ) <br>
            @endif
        @endforeach
    @endforeach
</div>
</body>
</html>
