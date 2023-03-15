<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
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


Route::group([ 'prefix' => 'admin'], function ()
{
    Route::get('login', [AuthController::class, 'adminLoginView']);
    Route::get('logout', [AuthController::class, 'adminLogout']);
    Route::post('login', [AuthController::class, 'adminLogin']);

        Route::group([ 'prefix' => 'home'], function ()
        {
            Auth::routes();
            Route::get('', [HomeController::class, 'index']);
        });

        Route::group([ 'prefix' => 'articles'], function ()
        {
            Route::group([ 'prefix' => '{id}'], function ()
            {
                Route::get('update', [ArticlesController::class, 'updateView']);
                Route::get('delete', [ArticlesController::class, 'delete']);
            });

            Route::get('', [ArticlesController::class, 'index']);
            Route::get('category/{category}', [ArticlesController::class, 'viewCategory']);

            Route::get('create', [ArticlesController::class, 'createView']);

            Route::post('update', [ArticlesController::class, 'update']);
            Route::post('create', [ArticlesController::class, 'create']);
        });

    Route::group([ 'prefix' => 'projects'], function ()
    {
        Route::get('', [ProjectsController::class, 'index']);
        Route::get('create', [ProjectsController::class, 'createView']);
    
        Route::post('update', [ProjectsController::class, 'update']);
        Route::post('create', [ProjectsController::class, 'create']);

        Route::group([ 'prefix' => '{id}'], function ()
        {
            Route::get('edit', [ProjectsController::class, 'updateView']);
            Route::get('delete', [ProjectsController::class, 'delete']);

                Route::group([ 'prefix' => 'members'], function ()
                {
                    Route::get('', [ProjectsController::class, 'membersIndex']); 
                    Route::post('create', [ProjectsController::class, 'membersCreate']);

                        Route::group([ 'prefix' => '{memberid}'], function ()
                        {
                            Route::get('update', [ProjectsController::class, 'membersUpdateView']); 
                            Route::post('update', [ProjectsController::class, 'membersUpdate']); 
                            Route::get('delete', [ProjectsController::class, 'rolesMembersDelete']);
                        
                        });
                });
        });
    });

    Route::group([ 'prefix' => 'roles'], function ()
        {

            Route::get('', [ProjectsController::class, 'rolesIndex']);
            Route::get('create', [RolesController::class, 'createView']);
            Route::post('update', [RolesController::class, 'update']);
            Route::post('create', [RolesController::class, 'create']);

                Route::group([ 'prefix' => '{id}'], function ()
                {
                Route::get('edit', [RolesController::class, 'updateView']);
                Route::get('delete', [RolesController::class, 'delete']);
                });

        });

    Route::group([ 'prefix' => 'categories'], function ()
    {
 
        Route::get('', [CategoriesController::class, 'index']);
        Route::get('/create', [CategoriesController ::class, 'createView']);
        Route::post('/create', [CategoriesController ::class, 'create']);
        Route::post('/update', [CategoriesController ::class, 'update']);

            Route::group([ 'prefix' => '{id}'], function ()
            {
                Route::get('edit', [CategoriesController::class, 'updateView']);
                Route::get('delete', [CategoriesController::class, 'delete']);
            });

    });
    
    Route::group([ 'prefix' => 'users'], function ()
    {

        Route::get('', [UsersController::class, 'adminView']);
        Route::get('/create', [UsersController ::class, 'createView']);
        Route::post('/create', [UsersController ::class, 'create']);
        Route::post('/update', [UsersController ::class, 'update']);

            Route::group([ 'prefix' => '{id}'], function ()
            {
                Route::get('update', [UsersController::class, 'updateView']);
                Route::get('delete', [UsersController::class, 'delete']);
                Route::get('removeadmin', [UsersController ::class, 'removeAdmin']);
                Route::get('makeadmin', [UsersController ::class, 'makeAdmin']);
            });
    });
});
