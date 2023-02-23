<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\HomeController;
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


Route::group([ 'prefix' => 'admin'], function ()
{
    Auth::routes();
    Route::get('', [HomeController::class, 'index']);
    Route::get('articles', [HomeController::class, 'indexArticles']);
    Route::get('projects', [HomeController::class, 'indexProjects']);
    Route::get('manageusers', [HomeController::class, 'indexUsers']);

});

Route::group([ 'prefix' => 'users'], function ()
{
    Route::get('login', [AuthController::class, 'loginView']);
    Route::get('register', [AuthController::class, 'registerView']);
    Route::get('logout', [AuthController ::class, 'logout']);
    Route::get('/manageusersview', [UsersController ::class, 'manageUserView'])/*->middleware('can:update,user')*/;
    
    Route::post('finishlogin', [AuthController::class,"login"]);
    Route::post('finishregister', [AuthController::class,"register"]);
    Route::post('/removeadmin', [UsersController ::class, 'removeAdmin'])/*->middleware('can:update,user')*/;
    Route::post('/makeadmin', [UsersController ::class, 'makeAdmin'])/*->middleware('can:update,user')*/;
});

Route::group([ 'prefix' => 'articles'], function ()
{
    Route::get('', [ArticlesController::class, 'dashboardView']);
    Route::get('dashboard', [ArticlesController::class, 'dashboardView']);
    Route::get('article/{id}', [ArticlesController ::class, 'articleView']);
    Route::get('article/{id}/edit', [ArticlesController::class, 'editView'])/*->middleware('can:update,article')*/;
    Route::get('createarticle', [ArticlesController ::class, 'createView'])/*->middleware('can:create,article')*/;
    
    Route::post('deletearticle', [ArticlesController ::class, 'delete'])/*->middleware('can:delete,article')*/;
    Route::post('editarticle', [ArticlesController ::class, 'update'])/*->middleware('can:update,article')*/;
    Route::post('createarticle', [ArticlesController ::class, 'create'])/*->middleware('can:delete,article')*/;
});

Route::group([ 'prefix' => 'projects'], function ()
{
Route::get('/projects', [ProjectsController ::class, 'view'])/*->middleware('can:viewAny,project')*/;
Route::get('/createproject', [ProjectsController ::class, 'createView'])/*->middleware('can:create,project')*/;
Route::get('/project/{id}', [ProjectsController ::class, 'projectView']);
Route::get('/project/{id}/edit', [ProjectsController::class, 'editView'])/*->middleware('can:update,project')*/;

Route::post('/createproject', [ProjectsController ::class, 'create'])/*->middleware('can:create,project')*/;
Route::post('/editproject', [ProjectsController ::class, 'update'])/*->middleware('can:update,project')*/;
Route::post('/deleteproject', [ProjectsController ::class, 'delete'])/*->middleware('can:delete,project')*/;
});
