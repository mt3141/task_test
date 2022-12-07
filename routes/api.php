<?php

use Illuminate\Http\Request;
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

Route::group(['prefix' => 'v1'], function (){
    Route::post('/register', [\App\Http\Controllers\Api\v1\AuthController::class, 'register'])->name('register');
    Route::post('/login', [\App\Http\Controllers\Api\v1\AuthController::class, 'login'])->name('login');
    Route::get('/logout', [\App\Http\Controllers\Api\v1\AuthController::class, 'logout'])->middleware('auth:api');

    Route::get('/task', [\App\Http\Controllers\Api\v1\TaskController::class, 'index'])->middleware('auth:api')->name('taskList');
    Route::post('/task', [\App\Http\Controllers\Api\v1\TaskController::class, 'create'])->middleware('auth:api')->name('taskCreate');
    Route::delete('/task/{id}', [\App\Http\Controllers\Api\v1\TaskController::class, 'destroy'])->middleware('auth:api')->name('taskDelete');
    Route::put('/task/{id}', [\App\Http\Controllers\Api\v1\TaskController::class, 'update'])->middleware('auth:api')->name('taskUpdate');
    Route::get('/task/assign/{taskId}/{userId?}', [\App\Http\Controllers\Api\v1\TaskController::class, 'assign'])->middleware('auth:api')->name('taskAssign');
    Route::get('/task/unassign/{taskId}/{userId?}', [\App\Http\Controllers\Api\v1\TaskController::class, 'unassign'])->middleware('auth:api')->name('taskUnAssign');


    Route::get('/user', [\App\Http\Controllers\Api\v1\UserController::class, 'index'])->middleware('auth:api')->name('userList');
});
