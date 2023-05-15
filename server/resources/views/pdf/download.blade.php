<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>About project</title>
</head>
<body>
<h1>My PDF-file about project</h1>
<div>Name: {{ $project->name }}</div>
<div>Description: {{ $project->descriptions }}</div>
<div>
    Users on this project:
    @foreach($project->users as $user)
        {{ $user->name }} ( role:  {{ $user->role->name }} ),
    @endforeach
</div>
</body>
</html>
