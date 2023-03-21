@extends('layouts.app')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

@section('content')
    <div class="container">
        <div class="search d-flex align-items-center">
            <a class="btn btn-primary" href="{{ route('home.projects') }}">My projects</a>
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
