<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Dashboard;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project, Dashboard $dashboard)
    {
        return view('Projects.Project.dashboards.tasks.create', ['project' => $project, 'dashboard' => $dashboard]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Project $project, Dashboard $dashboard)
    {
        $data = $request->except('_token');

        Task::create($data);

        //$dashboard->projects->attach($project->id);

        return view('Projects.Project.dashboards.show', ['dashboard' => $dashboard, 'project' => $project]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Dashboard $dashboard, Task $task)
    {
        $task->delete();

        return redirect()->route('home.project.dashboard.show', ['project' => $project, 'dashboard' => $dashboard]);
    }
}
