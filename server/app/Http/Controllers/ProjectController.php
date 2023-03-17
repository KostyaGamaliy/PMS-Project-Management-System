<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\StoreProjectRequest;
    use App\Http\Requests\UpdateProjectRequest;
    use App\Models\Project;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
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

            $dataProject['preview_image'] = Storage::disk('public')->put('/images/default-img-for-project.jpg');

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
        public function update(UpdateProjectRequest $request, string $id)
        {
            $validated = $request->validated();
            $validated['preview_image'] ? $validated['preview_image'] = Storage::disk('public')->put('/images', $validated['preview_image']) : $validated['preview_image'] = Storage::disk('public')->put('/images', $validated['preview_image']);
            DB::table('projects')->where('id', $id)->update($validated);

            return redirect()->route('home.projects');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $projects = Project::find($id);

            $projects->delete();

            return redirect()->route('home.projects');
        }
    }
