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
    use Pusher\Pusher;

    class ProjectController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index(Request $request)
        {
            $searchTerm = $request->query('search');
            $isDateSort = $request->query('byDate');
            $perPage = $request->query('perPage') ?? 10;
            $user = User::find($request->query('userId'));

            $projects = $user->projects();

            if ($isDateSort === 'true') {
                $projects->orderBy('created_at', 'desc');
            }

            if (!empty($searchTerm)) {
                $projects->where('name', 'like', "%$searchTerm%");
            }

            $projects = $projects->paginate($perPage);

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
            $this->authorize('view', $project);
            return new ProjectResource($project);
        }

        public function update(UpdateProjectRequest $request, $id)
        {
            $project = Project::findOrFail($id);
            $this->authorize('update', $project);

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
            $this->authorize('delete', $projects);

            if ($projects->preview_image !== "images/default-img-for-project.jpg") {
                Storage::disk('public')->delete($projects->preview_image);
            }
            $projects->delete();
        }

        public function downloadPDF(Project $project)
        {
            $data = [
                'project' => $project
            ];

            $pdf = app()->make('dompdf.wrapper');
            $pdf->loadView('pdf.download', $data);
            $pdfUrl = storage_path('app/public/project_report.pdf');
            $pdf->save($pdfUrl);

            $pusher = new Pusher('0ef8d31fe818b7949d4b', 'd6d3d4062d73d899ced9', '1601138', [
                'cluster' => 'eu',
                'useTLS' => true
            ]);
            $pusher->trigger('pms', 'pdf-ready', ['url' => asset('storage/project_report.pdf')]);

            return response()->json(['url' => asset('storage/project_report.pdf')]);
        }
    }
