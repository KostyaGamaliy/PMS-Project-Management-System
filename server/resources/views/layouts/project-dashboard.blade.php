<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Admin') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


</head>
<body>
<div class="container-fluid">
    <div class="row vh-100">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark col-md-4" style="width: 280px;">
            <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="{{ url('storage/' . ($project->preview_image ??  $default)) }}" alt="none image" width="40"
                     height="32" class="rounded-1 me-2">
                <span class="fs-4 text-truncate">{{ $project->name }}</span>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white" aria-current="page" href="#" role="button"
                           id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Dashboards
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach($project->dashboards as $dashboard)
                                <li>
                                    <a class="dropdown-item" href="{{ route('home.project.dashboard.show', ['project' => $project, 'dashboard' => $dashboard]) }}">{{ $dashboard->name }}</a>
                                </li>
                            @endforeach
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('home.project.dashboard.create', ['project' => $project]) }}">Create new table</a>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('home.project.members.index', ['dashboard' => $dashboard,   'project' => $project]) }}" class="nav-link text-white">
                        Members
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                   id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <strong>{{ Auth::user()->name }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="{{ route('home') }}">Home page</a></li>
                    <li><a class="dropdown-item" href="{{ route('home.projects.index') }}">My projects</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-9 mx-3">
            @yield('project')
        </div>
    </div>
</div>
</div>
</body>
</html>


