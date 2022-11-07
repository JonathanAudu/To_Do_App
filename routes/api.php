<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);



// projects Route
Route::post('/project-create', [ProjectController::class, 'createProject']);
Route::get('/all-projects', [ProjectController::class, 'getAllProject']);
Route::get('/user-projects/{$project_id}', [ProjectController::class, 'getEachProject']);



// Task Routes
Route::post('/task-create', [ProjectController::class, 'createTask']);
Route::get('/all-tasks', [ProjectController::class, 'getAllTask']);
Route::get('/user-tasks/{$task_id}', [ProjectController::class, 'getEachTask']);
