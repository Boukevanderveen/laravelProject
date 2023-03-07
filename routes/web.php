<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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

Route::get('admin/login', [AuthController::class, 'adminLoginView']);
Route::get('admin/logout', [AuthController::class, 'adminLogout']);
Route::post('adminlogin', [AuthController::class, 'adminLogin']);


Route::group([ 'prefix' => 'admin','middleware' => 'is_admin'], function ()
{
    Route::group([ 'prefix' => 'home'], function ()
    {
    Auth::routes();
    Route::get('', [HomeController::class, 'index']);
    });

    Route::group([ 'prefix' => 'articles'], function ()
    {
        Route::get('', [ArticlesController::class, 'index']);
        Route::get('category/{
            
        }', [ArticlesController::class, 'viewCategory']);
        Route::get('{id}/update', [ArticlesController::class, 'updateView']);
        Route::get('{id}/delete', [ArticlesController::class, 'delete']);

        Route::get('create', [ArticlesController::class, 'createView']);

        Route::post('update', [ArticlesController::class, 'update']);
        Route::post('create', [ArticlesController::class, 'create']);
    });

    Route::group([ 'prefix' => 'projects'], function ()
    {

    Route::get('', [ProjectsController::class, 'index']);
    Route::get('create', [ProjectsController::class, 'createView']);
    Route::get('{id}/edit', [ProjectsController::class, 'editView']);
    Route::get('{id}/delete', [ProjectsController::class, 'delete']);

    Route::post('update', [ProjectsController::class, 'update']);
    Route::post('create', [ProjectsController::class, 'create']);

    });

    Route::group([ 'prefix' => 'categories'], function ()
    {
    Route::get('', [CategoriesController::class, 'index']);
    Route::get('{id}/edit', [CategoriesController::class, 'updateView']);
    Route::get('{id}/delete', [CategoriesController::class, 'delete']);

    Route::get('/create', [CategoriesController ::class, 'createView']);

    Route::post('/create', [CategoriesController ::class, 'create']);
    Route::post('/update', [CategoriesController ::class, 'update']);

    });
    
    Route::group([ 'prefix' => 'users'], function ()
    {
    Route::get('', [UsersController::class, 'adminView']);
    Route::get('{id}/update', [UsersController::class, 'updateView']);
    Route::get('{id}/delete', [UsersController::class, 'delete']);

    Route::get('/create', [UsersController ::class, 'createView']);

    Route::post('/create', [UsersController ::class, 'create']);
    Route::post('/update', [UsersController ::class, 'update']);


    });
});

Route::get('/login', [AuthController ::class, 'loginView']);



