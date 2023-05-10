<?php

    use App\Http\Controllers\Api\DashboardController;
    use App\Http\Controllers\Api\MemberController;
    use App\Http\Controllers\Api\RoleController;
    use App\Http\Controllers\Api\TaskController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\AuthController;
    use \App\Http\Controllers\Api\ProjectController;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "api" middleware group. Make something great!
    |
    */

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::group(['middleware' => 'auth:sanctum'], function () {
//    Route::get('/get', GetController::class);
//});

    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
    Route::put('/projects/{project}/update', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}/destroy', [ProjectController::class, 'destroy']);

    Route::get('/projects/{id}/tasks', [TaskController::class, 'index']);
    Route::get('/projects/tasks/{id}', [TaskController::class, 'show']);
    Route::post('/projects/tasks/store', [TaskController::class, 'store']);
    Route::put('/projects/tasks/{id}/update', [TaskController::class, 'update']);
    Route::delete('/projects/tasks/{id}/destroy', [TaskController::class, 'destroy']);

    Route::get('/projects/{id}/dashboards', [DashboardController::class, 'index']);
    Route::get('/projects/{projectId}/dashboards/{dashboardId}', [DashboardController::class, 'show']);
    Route::post('/projects/{id}/dashboards/store', [DashboardController::class, 'store']);
    Route::put('/projects/dashboards/{id}/update', [DashboardController::class, 'update']);
    Route::delete('/projects/dashboards/{id}/destroy', [DashboardController::class, 'destroy']);

    Route::get('/roles', [RoleController::class, 'index']);

    Route::get('/projects/members/{memberId}', [MemberController::class, 'show']);
    Route::get('/projects/{id}/members/edit', [MemberController::class, 'edit']);
    Route::put('/projects/members/{memberId}/update/{roleId}', [MemberController::class, 'update']);
    Route::delete('/projects/{projectId}/members/{memberId}/destroy', [MemberController::class, 'destroy']);
