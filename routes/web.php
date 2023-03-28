<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\StatusesController;

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

    Route::get('/', function () {
        return view('index');
    });

    Route::group([ 'prefix' => 'articles', 'as' => 'articles.'], function ()
    {
        Route::get('', [ArticlesController::class, 'index']);
        Route::get('create', [ArticlesController::class, 'create']);
        Route::post('update', [ArticlesController::class, 'update']);
        Route::post('store', [ArticlesController::class, 'store']);
        
        Route::group([ 'prefix' => '{article}'], function ()
        {
            Route::get('edit', [ArticlesController::class, 'edit'])->name('edit');
            Route::get('destroy', [ArticlesController::class, 'destroy'])->name('destroy');
            Route::get('show', [ArticlesController::class, 'show'])->name('show');

        });
    });

    Route::group([ 'prefix' => 'projects', 'as' => 'projects.'], function ()
    {
        Route::get('', [ProjectsController::class, 'index']);
        Route::get('create', [ProjectsController::class, 'create']);
    
        Route::post('update', [ProjectsController::class, 'update']);
        Route::post('store', [ProjectsController::class, 'store']);

        Route::group([ 'prefix' => '{project}'], function ()
        {
            Route::get('edit', [ProjectsController::class, 'edit'])->name('edit');
            Route::get('destroy', [ProjectsController::class, 'destroy'])->name('destroy');

                Route::group([ 'prefix' => 'members'], function ()
                {
                    Route::get('', [ProjectsController::class, 'membersIndex']); 
                    Route::post('store', [ProjectsController::class, 'membersStore']);

                        Route::group([ 'prefix' => '{memberid}'], function ()
                        {
                            Route::get('edit', [ProjectsController::class, 'membersEdit']);
                            Route::post('update', [ProjectsController::class, 'membersUpdate']); 
                            Route::get('destroy', [ProjectsController::class, 'rolesMembersDestroy']);
                        
                        });
                });

                Route::group([ 'prefix' => 'tasks', 'as' => 'tasks.'], function ()
                {
                    Route::post('store', [ProjectsController::class, 'tasksStore'])->name('store'); 

                    Route::group([ 'prefix' => '{task}'], function ()
                    {
                        Route::get('complete', [ProjectsController::class, 'tasksComplete'])->name('complete');
                        Route::get('uncomplete', [ProjectsController::class, 'tasksUncomplete'])->name('uncomplete');


                        Route::get('edit', [ProjectsController::class, 'tasksEdit'])->name('edit');
                        Route::post('update', [ProjectsController::class, 'tasksUpdate'])->name('update'); 
                        Route::get('destroy', [ProjectsController::class, 'tasksDestroy'])->name('destroy');
                    
                    });

                    Route::group([ 'prefix' => '{sort}'], function ()
                    {
                        Route::get('sortmember', [ProjectsController::class, 'tasksSort'])->name('sortmember');
                        Route::get('sortstatus', [ProjectsController::class, 'statusesSort'])->name('sortstatus');
                    });
                });
        });
    });

    Route::group([ 'prefix' => 'categories', 'as' => 'categories.'], function ()
    {
 
        Route::get('', [CategoriesController::class, 'index']);
        Route::get('/create', [CategoriesController ::class, 'create']);
        Route::post('/store', [CategoriesController ::class, 'store']);
        Route::post('/update', [CategoriesController ::class, 'update']);

            Route::group([ 'prefix' => '{id}'], function ()
            {
                Route::get('edit', [CategoriesController::class, 'edit'])->name('edit');
                Route::get('destroy', [CategoriesController::class, 'destroy'])->name('destroy');
            });

    });
    
    Route::group([ 'prefix' => 'users', 'as' => 'users.'], function ()
    {

        Route::get('', [UsersController::class, 'index']);
        Route::get('/create', [UsersController ::class, 'create']);
        Route::post('/store', [UsersController ::class, 'store']);
        Route::post('/update', [UsersController ::class, 'update']);

            Route::group([ 'prefix' => '{id}'], function ()
            {
                Route::get('edit', [UsersController::class, 'edit'])->name('edit');
                Route::get('destroy', [UsersController::class, 'destroy'])->name('destroy');
            });
    });

    Route::group([ 'prefix' => 'roles', 'as' => 'roles.'], function ()
    {

        Route::get('', [RolesController::class, 'index']);
        Route::get('create', [RolesController::class, 'create']);
        Route::post('update', [RolesController::class, 'update']);
        Route::post('store', [RolesController::class, 'store']);

        Route::group([ 'prefix' => '{role}'], function ()
        {
            Route::get('edit', [RolesController::class, 'edit'])->name('edit');
            Route::get('destroy', [RolesController::class, 'destroy'])->name('destroy');
        });

    });

    Route::group([ 'prefix' => 'tasks', 'as' => 'tasks.'], function ()
    {
        Route::get('', [TasksController::class, 'index']);
        Route::get('create', [TasksController::class, 'create']);
        Route::post('store', [TasksController::class, 'store']);

        Route::group([ 'prefix' => '{task}'], function ()
        {
            Route::post('update', [TasksController::class, 'update'])->name('update');;
            Route::get('edit', [TasksController::class, 'edit'])->name('edit');
            Route::get('destroy', [TasksController::class, 'destroy'])->name('destroy');
        });
    });
    Route::group([ 'prefix' => 'statuses', 'as' => 'statuses.'], function ()
    {
        Route::get('', [StatusesController::class, 'index']);
        Route::get('create', [StatusesController::class, 'create']);
        Route::post('store', [StatusesController::class, 'store']);

        Route::group([ 'prefix' => '{status}'], function ()
        {
        Route::post('update', [StatusesController::class, 'update'])->name('update');
            Route::get('edit', [StatusesController::class, 'edit'])->name('edit');
            Route::get('destroy', [StatusesController::class, 'destroy'])->name('destroy');
        });
    });


Route::group([ 'prefix' => 'admin', 'as' => 'admin.'], function ()
{
    Route::get('login', [AuthController::class, 'adminLoginView']);
    Route::get('logout', [AuthController::class, 'adminLogout']);
    Route::post('login', [AuthController::class, 'adminLogin']);


        Auth::routes();
        Route::get('/', function () {
            return view('admin.index');
        });
        

        Route::group([ 'prefix' => 'articles', 'as' => 'articles.'], function ()
        {
            Route::group([ 'prefix' => '{article}'], function ()
            {
                Route::get('edit', [ArticlesController::class, 'adminEdit'])->name('edit');
                Route::get('destroy', [ArticlesController::class, 'adminDestroy'])->name('destroy');
            });

            Route::get('', [ArticlesController::class, 'adminIndex']);
            Route::get('create', [ArticlesController::class, 'adminCreate']);
            Route::post('update', [ArticlesController::class, 'adminUpdate']);
            Route::post('store', [ArticlesController::class, 'adminStore']);
        });

    Route::group([ 'prefix' => 'projects', 'as' => 'projects.'], function ()
    {
        Route::get('', [ProjectsController::class, 'adminIndex']);
        Route::get('create', [ProjectsController::class, 'adminCreate']);
    
        Route::post('update', [ProjectsController::class, 'adminUpdate']);
        Route::post('store', [ProjectsController::class, 'adminStore']);

        Route::group([ 'prefix' => '{project}'], function ()
        {
            Route::get('edit', [ProjectsController::class, 'adminEdit'])->name('edit');
            Route::get('destroy', [ProjectsController::class, 'adminDestroy'])->name('destroy');

                Route::group([ 'prefix' => 'members'], function ()
                {
                    Route::get('', [ProjectsController::class, 'adminMembersIndex']); 
                    Route::post('store', [ProjectsController::class, 'adminMembersStore']);

                        Route::group([ 'prefix' => '{memberid}'], function ()
                        {
                            Route::get('edit', [ProjectsController::class, 'adminMembersEdit']);
                            Route::post('update', [ProjectsController::class, 'adminMembersUpdate']); 
                            Route::get('destroy', [ProjectsController::class, 'adminRolesMembersDestroy']);
                        
                        });
                });

                Route::group([ 'prefix' => 'tasks', 'as' => 'tasks.'], function ()
                {
                    Route::post('store', [ProjectsController::class, 'adminTasksStore'])->name('store'); 

                    Route::group([ 'prefix' => '{task}'], function ()
                    {
                        Route::get('complete', [ProjectsController::class, 'adminTasksComplete'])->name('complete');
                        Route::get('uncomplete', [ProjectsController::class, 'adminTasksUncomplete'])->name('uncomplete');


                        Route::get('edit', [ProjectsController::class, 'adminTasksEdit'])->name('edit');
                        Route::post('update', [ProjectsController::class, 'adminTasksUpdate'])->name('update'); 
                        Route::get('destroy', [ProjectsController::class, 'adminTasksDestroy'])->name('destroy');
                    
                    });

                    Route::group([ 'prefix' => '{sort}'], function ()
                    {
                        Route::get('sortstatus', [ProjectsController::class, 'adminTasksSortStatus'])->name('sortstatus');
                        Route::get('sortmember', [ProjectsController::class, 'adminTasksSortMember'])->name('sortmember');

                    });
                });
        });
    });

    Route::group([ 'prefix' => 'categories', 'as' => 'categories.'], function ()
    {
 
        Route::get('', [CategoriesController::class, 'adminIndex']);
        Route::get('/create', [CategoriesController ::class, 'adminCreate']);
        Route::post('/store', [CategoriesController ::class, 'adminStore']);
        Route::post('/update', [CategoriesController ::class, 'adminUpdate']);

            Route::group([ 'prefix' => '{id}'], function ()
            {
                Route::get('edit', [CategoriesController::class, 'adminEdit'])->name('edit');
                Route::get('destroy', [CategoriesController::class, 'adminDestroy'])->name('destroy');
            });

    });
    
    Route::group([ 'prefix' => 'users', 'as' => 'users.'], function ()
    {

        Route::get('', [UsersController::class, 'adminIndex']);
        Route::get('/create', [UsersController ::class, 'adminCreate']);
        Route::post('/store', [UsersController ::class, 'adminStore']);
        Route::post('/update', [UsersController ::class, 'adminUpdate']);

            Route::group([ 'prefix' => '{id}'], function ()
            {
                Route::get('edit', [UsersController::class, 'adminEdit'])->name('edit');
                Route::get('destroy', [UsersController::class, 'adminDestroy'])->name('destroy');
            });
    });

    Route::group([ 'prefix' => 'roles', 'as' => 'roles.'], function ()
    {

        Route::get('', [ProjectsController::class, 'adminRolesIndex']);
        Route::get('create', [RolesController::class, 'adminCreate']);
        Route::post('update', [RolesController::class, 'adminUpdate']);
        Route::post('store', [RolesController::class, 'adminStore']);

        Route::group([ 'prefix' => '{role}'], function ()
        {
            Route::get('edit', [RolesController::class, 'adminEdit'])->name('edit');
            Route::get('destroy', [RolesController::class, 'adminDestroy'])->name('destroy');
        });

    });

    Route::group([ 'prefix' => 'tasks', 'as' => 'tasks.'], function ()
    {
        Route::get('', [TasksController::class, 'adminIndex']);
        Route::get('create', [TasksController::class, 'adminCreate']);
        Route::post('store', [TasksController::class, 'adminStore']);

        Route::group([ 'prefix' => '{task}'], function ()
        {
            Route::post('update', [TasksController::class, 'adminUpdate'])->name('update');;
            Route::get('edit', [TasksController::class, 'adminEdit'])->name('edit');
            Route::get('destroy', [TasksController::class, 'adminDestroy'])->name('destroy');
        });
    });
    Route::group([ 'prefix' => 'statuses', 'as' => 'statuses.'], function ()
    {
        Route::get('', [StatusesController::class, 'adminIndex']);
        Route::get('create', [StatusesController::class, 'adminCreate']);
        Route::post('store', [StatusesController::class, 'adminStore']);

        Route::group([ 'prefix' => '{status}'], function ()
        {
        Route::post('update', [StatusesController::class, 'adminUpdate'])->name('update');
            Route::get('edit', [StatusesController::class, 'adminEdit'])->name('edit');
            Route::get('destroy', [StatusesController::class, 'adminDestroy'])->name('destroy');
        });
    });
});
