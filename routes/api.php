<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactRequestsController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EducationLevelsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\UsersController;

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

Route::get('/skills/{userId:id}', [SkillsController::class, 'getAll'])->where('type', '[0-9]+');

Route::get('/educationlevels', [EducationLevelsController::class, 'getAll']);

Route::get('/education/{userId:id}', [EducationController::class, 'getAll'])->where('type', '[0-9]+');

Route::get('/projects/{userId:id}', [ProjectsController::class, 'getAll'])->where('type', '[0-9]+');
Route::get('/users/{userId:id}', [UsersController::class, 'getAll'])->where('type', '[0-9]+');
Route::get('/contactrequests/{userId:id}', [ContactRequestsController::class, 'getAll'])->where('type', '[0-9]+');
Route::post('/contactrequests', [ContactRequestsController::class, 'store'])->where('type', '[0-9]+');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
