<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UsersController;
use App\Events\formSubmitted;
use Illuminate\Support\Facades\DB;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth controller

Route::get('login', [AuthController::class, 'loginView']);
Route::get('register', [AuthController::class, 'registerView']);
Route::get('logout', [AuthController ::class, 'logout']);

Route::post('/finishlogin', [AuthController::class,"login"]);
Route::post('/finishregister', [AuthController::class,"register"]);


// Articles controller

Route::get('', [ArticlesController::class, 'dashboardView']);
Route::get('dashboard', [ArticlesController::class, 'dashboardView']);
Route::get('/article/{id}', [ArticlesController ::class, 'articleView']);
Route::get('/article/{id}/edit', [ArticlesController::class, 'editView']);
Route::get('/createarticle', [ArticlesController ::class, 'createView']);

Route::post('/deletearticle', [ArticlesController ::class, 'delete']);
Route::post('/editarticle', [ArticlesController ::class, 'edit']);
Route::post('/createarticle', [ArticlesController ::class, 'create']);


// Users controller

Route::get('/manageusersview', [UsersController ::class, 'manageUserView']);

Route::post('/removeadmin', [UsersController ::class, 'removeAdmin']);
Route::post('/makeadmin', [UsersController ::class, 'makeAdmin']);

