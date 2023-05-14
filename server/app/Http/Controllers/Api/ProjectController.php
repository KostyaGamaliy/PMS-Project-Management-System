<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreProjectRequest;
    use App\Http\Requests\UpdateProjectRequest;
    use App\Http\Resources\ProjectResource;
    use App\Jobs\SendCreateProjectJob;
    use App\Models\Project;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Mail;
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

        public function store(Request $request)
        {
            $userId = $request->input('user_id');
            $user = User::find($request->input('user_id'));

            $data['name'] = $request->input('name');
            $data['descriptions'] = $request->input('descriptions');

            if ($request->hasFile('preview_image')) {
                $image = $request->file('preview_image');
                $data['preview_image'] = $image->store('images', 'public');
            } else {
                $data['preview_image'] = 'images/default-img-for-project.jpg';
            }

            $project = Project::create($data);

            $project->users()->attach($userId);

            $emailData = [
                'name' => $user->name,
                'email' => $user->email,
                'project' => $project
            ];

            SendCreateProjectJob::dispatch($emailData);
        }

        public function show(Project $project)
        {
            return new ProjectResource($project);
        }

        public function update(UpdateProjectRequest $request, $id)
        {
            $project = Project::findOrFail($id);

            $data['name'] = request()->input('name');
            $data['descriptions'] = $request->input('descriptions');

            if ($request->hasFile('preview_image')) {
                $image = $request->file('preview_image');
                $data['preview_image'] = $image->store('images', 'public');
            } else {
                $data['preview_image'] = 'images/default-img-for-project.jpg';
            }

            $project->update($data);

            return new ProjectResource($project);
        }

        public function destroy(string $id)
        {
            $projects = Project::find($id);

            if ($projects->preview_image !== "images/default-img-for-project.jpg") {
                Storage::disk('public')->delete($projects->preview_image);
            }
            $projects->delete();
        }
    }
