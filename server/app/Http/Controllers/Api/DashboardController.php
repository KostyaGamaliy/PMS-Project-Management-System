<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDashboardRequest;
use App\Http\Requests\UpdateDashboardRequest;
use App\Http\Resources\DashboardResource;
use App\Models\Dashboard;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($id) {
        $dashboards = Project::findOrFail($id)->dashboards;

        return response()->json(['dashboards' => $dashboards]);
    }

    public function show($projectId, $dashboardId) {
        $project = Project::find($projectId);
        $this->authorize('view', $project);

        $dashboard = Dashboard::find($dashboardId);
        return new DashboardResource($dashboard);
    }

    public function store(StoreDashboardRequest $request) {
        $data = $request->validated();

        $dashboard = Dashboard::create($data);
//        return response()->json(['dashboard' => $dashboard]);
    }

    public function update(UpdateDashboardRequest $request, $id) {
        $dashboard = Dashboard::findOrFail($id);
        $data = $request->validated();
        $dashboard->update($data);

        return new DashboardResource($dashboard);
    }

    public function destroy($id) {
        $dashboard = Dashboard::find($id);
        $dashboard->delete();
    }
}
