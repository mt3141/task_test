<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('/users/list-members', [UserController::class, 'listMembers']);
    Route::get('/users/list-admins', [UserController::class, 'listAdmins']);

    Route::apiResource('tasks', 'TaskController')->only(['store', 'update', 'index', 'destroy']);
    Route::post('tasks/{task}/assign', [TaskController::class, 'assignToMe']);
});
