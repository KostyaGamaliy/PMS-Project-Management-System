@extends('layouts.app')


@section('content')
    <div class="container py-3">
        <div class="search d-flex align-items-center">
            <a class="btn btn-primary" href="{{ route('home.projects.index') }}">My projects</a>
        </div>

        @php
        $users = \App\Models\User::all();

				foreach ($users as $user) {
					echo 'User: ' . $user['name'] . '<br>';
					echo '<b>Projects:<b><br>';
					foreach ($user->projects as $project) {
						echo $project['name'] . '<br>';

					}
					echo '--------------------<br>';
				}
        @endphp
    </div>
@endsection
