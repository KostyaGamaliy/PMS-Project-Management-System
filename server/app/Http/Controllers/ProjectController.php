<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\StoreProjectRequest;
    use App\Http\Requests\UpdateProjectRequest;
    use App\Models\Project;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Session;

    class ProjectController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $projects = Project::all();
            return view('Projects.projects', compact('projects'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(StoreProjectRequest $request)
        {
            //dd($request->file());
            $dataProject = $request->validated();

            $dataProject['preview_image'] = Storage::disk('public')->put('/images', $dataProject['preview_image']);

            $project = Project::create($dataProject);

            return redirect()->route('home.projects');
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(UpdateProjectRequest $request, Project $project)
        {
            $validated = $request->validated();
            $validated['preview_image'] = Storage::disk('public')->put('/images', $validated['preview_image']);
            $project->update($validated);

            return redirect()->route('home.projects');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $projects = Project::findOrFail($id);

            $projects->delete();

            return redirect()->route('home.projects');
        }
    }
