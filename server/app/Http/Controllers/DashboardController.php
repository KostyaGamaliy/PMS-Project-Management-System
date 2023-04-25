<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardRequest;
use App\Http\Requests\UpdateDashboardRequest;
use App\Models\Dashboard;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('Projects.Project.dashboards.create', ['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDashboardRequest $request, Project $project)
    {
        $data = $request->except('_token');
        //$data['project_id'] = $project->id;
        //dd($data);
        $dashboard = Dashboard::create($data);

        //$dashboard->projects->attach($project->id);

        return redirect()->route('admin.projects.show', ['project' => $project]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $project_id, string $dashboard_id)
    {
        $project = Project::where('id', $project_id)->first();
        $dashboard = Dashboard::where('id', $dashboard_id)->first();

        return view('Projects.Project.dashboards.show', ['dashboard' => $dashboard, 'project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Dashboard $dashboard)
    {
        return view('Projects.Project.dashboards.edit', compact('project', 'dashboard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDashboardRequest $request, Project $project, Dashboard $dashboard)
    {
        $data = $request->except('_token', '_method');

        $dashboard->update($data);

        return redirect()->route('admin.project.dashboard.show', ['project' => $project, 'dashboard' => $dashboard]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Dashboard $dashboard)
    {
        //dd($project, $dashboard);
        $dashboard->delete();

        return redirect()->route('admin.projects.show', ['project' => $project]);
    }
}
