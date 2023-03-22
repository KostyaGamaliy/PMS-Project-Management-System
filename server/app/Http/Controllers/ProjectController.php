<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\StoreProjectRequest;
    use App\Http\Requests\UpdateProjectRequest;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Project;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Session;

    class ProjectController extends Controller
    {
        public $defaultPath = "images/default-img-for-project.jpg";
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $projects = Project::all();

            $user = Auth::user();

            return view('Projects.projects', ['projects' => $projects, 'user' => $user, 'default' => $this->defaultPath]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view("Projects.create");
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(StoreProjectRequest $request)
        {
            $data = $request->except('_token');

            $userId = $request->get('user_id');

            if ($request->hasFile('preview_image')) {
                $image = $request->file('preview_image');
                $data['preview_image'] = $image->store('images', 'public');
            }

            $project = Project::create($data);

            $project->users()->attach($userId);

            return redirect()->route('home.projects');
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            $project = Project::where('id', $id)->first();
            $user = Auth::user();

            return view("layouts.projectSidebar", ['project' => $project, 'default' => $this->defaultPath, 'user' => $user]);
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

            $data = $request->except('_token');
            unset($data['_method']);

            $project = Project::where('id', $id)->first();
            $fieldNames = $project->getAttributes();

            if (isset($data['preview_image'])) {
                if (!is_null($fieldNames['preview_image'])) {
                    Storage::disk('public')->delete($project->preview_image);
                }

                $image = $request->file('preview_image');
                $data['preview_image'] = $image->store('images', 'public');
            }

            DB::table('projects')->where('id', $id)->update($data);

            return redirect()->route('home.projects');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $projects = Project::find($id);

            if ($projects->preview_image){
                Storage::disk('public')->delete($projects->preview_image);
            }
            $projects->delete();

            return redirect()->route('home.projects');
        }
    }
