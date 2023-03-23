<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::redirect('/', '/login');

    Route::get('/home', function () {
        if (session('status')) {
            return redirect()->route('home')->with('status', session('status'));
        }
        return view('home');
    })->name('home');

    Route::group([
        'as' => 'home.',
        'prefix' => 'home',
    ], function() {
        Route::resource('projects', \App\Http\Controllers\ProjectController::class);

        //Route::get('/project/{project_id}/members', [\App\Http\Controllers\ProjectController::class, 'show'])->name('show');

        Route::group([
            'as' => 'project.dashboard.',
            'prefix' => '/project',
        ], function() {
            Route::get('/{project}/board/create',  [\App\Http\Controllers\DashboardController::class, 'create'])->name('create');
            Route::post('/{project}/board/store',  [\App\Http\Controllers\DashboardController::class, 'store'])->name('store');
            Route::get('/{project_id}/board/{dashboard_id}', [\App\Http\Controllers\DashboardController::class, 'show'])->name('show');
        });

    });

    Route::post('updateLastModal', [\App\Http\Controllers\HomeController::class, 'updateLastModal'])->name('home.updateLastModal');

