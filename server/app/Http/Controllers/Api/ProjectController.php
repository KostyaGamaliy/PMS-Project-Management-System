<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\UpdateProjectRequest;
    use App\Http\Resources\ProjectResource;
    use App\Models\Project;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    class ProjectController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index(Request $request)
        {
            $searchTerm = $request->query('search');
            $perPage = $request->query('perPage') ?? 10;

            $user = User::find($request->query('userId'));

            if (!empty($searchTerm)) {
                $projects = $user->projects()->where('name', 'like', "%$searchTerm%")->paginate($perPage);
            } else {
                $projects = $user->projects()->paginate($perPage);
            }

            return ProjectResource::collection($projects)->additional([
                'pagination' => [
                    'currentPage' => $projects->currentPage(),
                    'perPage' => $projects->perPage(),
                    'totalPages' => $projects->lastPage(),
                    'totalItems' => $projects->total(),
                ]
            ]);
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
        public function store(Request $request)
        {
            //
        }

        /**
         * Display the specified resource.
         */
        public function show(Project $project)
        {
            return new ProjectResource($project);
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
        public function update(UpdateProjectRequest $request, $id)
        {
            $project = Project::findOrFail($id);
            $data = $request->validated();
            $project->update($data);
//            $data = $request->except('_token', '_method');
//
//            $fieldNames = $project->getAttributes();

//            if (isset($data['preview_image'])) {
//                if (!is_null($fieldNames['preview_image'])) {
//                    Storage::disk('public')->delete($project->preview_image);
//                }
//
//                $image = $request->file('preview_image');
//                $data['preview_image'] = $image->store('images', 'public');
//            }

//            $project->update($data);
            return new ProjectResource($project);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $projects = Project::find($id);

            if ($projects->preview_image !== "images/default-img-for-project.jpg") {
                Storage::disk('public')->delete($projects->preview_image);
            }
            $projects->delete();
        }
    }
