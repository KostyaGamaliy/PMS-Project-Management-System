<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Dashboard;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($id) {
        $tasks = Dashboard::findOrFail($id)->tasks;

        return response()->json(['tasks' => $tasks]);
    }

    public function show($id) {
        $task = Task::find($id);
        return new TaskResource($task);
    }

    public function destroy($id) {
        $task = Task::find($id);
        $task->delete();
    }
}
