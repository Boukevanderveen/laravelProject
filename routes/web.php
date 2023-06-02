<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\AdressesController;
use Dompdf\Dompdf;

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
    
    auth::routes();

    Route::group([ 'prefix' => 'orders', 'as' => 'orders.'], function ()
    {
        Route::get('create', [OrdersController::class, 'create'])->name('create');
        Route::post('store', [OrdersController::class, 'store'])->name('store');
        Route::post('createinvoice', [OrdersController::class, 'createInvoice'])->name('createinvoice');

        Route::get('index', [OrdersController::class, 'index'])->name('index');
        Route::get('{order}/show', [OrdersController::class, 'show'])->name('show');

        Route::group([ 'prefix' => 'adresses', 'as' => 'adresses.'], function ()
        {
            Route::group([ 'prefix' => 'delivery', 'as' => 'delivery.'], function ()
            {
            Route::get('create', [OrdersController::class, 'adressesDeliveryCreate'])->name('create');
            Route::post('store', [OrdersController::class, 'adressesDeliveryStore'])->name('store');
            });
            Route::group([ 'prefix' => 'invoices', 'as' => 'invoices.'], function ()
            {
            Route::post('create', [OrdersController::class, 'adressesInvoicesCreate'])->name('create');
            Route::post('store', [OrdersController::class, 'adressesInvoicesStore'])->name('store');
            });

        });
    });

    Route::group([ 'prefix' => 'products', 'as' => 'products.'], function ()
    {
        Route::get('', [ProductsController::class, 'index'])->name('index');

        Route::group([ 'prefix' => '{product}'], function ()
        {
            Route::get('show', [ProductsController::class, 'show'])->name('show');
        });
        
        Route::get('cart', [ProductsController::class, 'cart'])->name('cart');
        Route::post('add-to-cart', [ProductsController::class, 'addToCart'])->name('add.to.cart');
        Route::patch('update-cart', [ProductsController::class, 'updateCard'])->name('update.cart');
        Route::delete('remove-from-cart', [ProductsController::class, 'remove'])->name('remove.from.cart');

    });

    Route::group([ 'prefix' => 'adresses', 'as' => 'adresses.'], function ()
    {
        Route::get('', [AdressesController::class, 'index'])->name('index');
        Route::get('create', [AdressesController::class, 'create'])->name('create');
        Route::post('store', [AdressesController::class, 'store'])->name('store');

        Route::group([ 'prefix' => '{adress}'], function ()
        {
            Route::delete('destroy', [AdressesController::class, 'destroy'])->name('destroy');
            Route::get('show', [AdressesController::class, 'show'])->name('show');
            Route::get('edit', [AdressesController::class, 'edit'])->name('edit');
            Route::post('update', [AdressesController::class, 'update'])->name('update');

        });

    });


    Route::group([ 'prefix' => 'articles', 'as' => 'articles.'], function ()
    {
        Route::get('', [ArticlesController::class, 'index'])->name('index');
        Route::get('create', [ArticlesController::class, 'create'])->name('create');
        Route::post('update', [ArticlesController::class, 'update'])->name('update');
        Route::post('store', [ArticlesController::class, 'store'])->name('store');;
        Route::get('search', [ArticlesController::class, 'searchIndex'])->name('search');

        Route::group([ 'prefix' => '{article}'], function ()
        {
            Route::get('edit', [ArticlesController::class, 'edit'])->name('edit');
            Route::delete('destroy', [ArticlesController::class, 'destroy'])->name('destroy');
            Route::get('show', [ArticlesController::class, 'show'])->name('show');

        });
    });

    Route::group([ 'prefix' => 'projects', 'as' => 'projects.'], function ()
    {
        Route::get('', [ProjectsController::class, 'index'])->name('index');
        Route::get('create', [ProjectsController::class, 'create'])->name('create');;
    
        Route::post('update', [ProjectsController::class, 'update'])->name('update');;
        Route::post('store', [ProjectsController::class, 'store'])->name('store');;

        Route::group([ 'prefix' => '{project}'], function ()
        {
            Route::get('edit', [ProjectsController::class, 'edit'])->name('edit');
            Route::get('destroy', [ProjectsController::class, 'destroy'])->name('destroy');
            Route::get('show', [ProjectsController::class, 'show'])->name('show');

                Route::group([ 'prefix' => 'members.'], function ()
                {
                    //Route::get('', [ProjectsController::class, 'membersIndex'])->name('index');
                    Route::post('store', [ProjectsController::class, 'membersStore'])->name('store');

                        Route::group([ 'prefix' => '{member}'], function ()
                        {
                        Route::get('membersedit', [ProjectsController::class, 'membersEdit'])->name('membersedit');
                            Route::post('update', [ProjectsController::class, 'membersUpdate'])->name('update'); 
                            Route::get('destroy', [ProjectsController::class, 'rolesMembersDestroy'])->name('destroy');
                        
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

    

Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'middlware' => ['auth']], function ()
{
    Route::get('login', [AuthController::class, 'adminLogin'])->name('login');

        Route::get('', [HomeController::class, 'adminIndex'])->name('index');
        
        Route::group([ 'prefix' => 'orders', 'as' => 'orders.'], function ()
        {

            Route::get('', [OrdersController::class, 'adminIndex'])->name('index');

            Route::group([ 'prefix' => '{order}'], function ()
            {
                Route::post('update', [OrdersController ::class, 'update'])->name('update');
                Route::get('edit', [OrdersController::class, 'edit'])->name('edit');
                Route::delete('destroy', [OrdersController::class, 'destroy'])->name('destroy');
                Route::get('invoice', [OrdersController::class, 'invoice'])->name('invoice');
                Route::get('mail', [OrdersController::class, 'mail'])->name('mail');
                Route::get('shipmentadress', [OrdersController::class, 'shipmentadress'])->name('shipmentadress');

                Route::group([  'prefix' => 'shipmentadresses', 'as' => 'shipmentadresses.'], function ()
                {
                    Route::group([ 'prefix' => '{orderadress}'], function ()
                    {
                        Route::get('edit', [OrdersController::class, 'shipmentAdressEdit'])->name('edit');
                        Route::post('update', [OrdersController ::class, 'shipmentAdressUpdate'])->name('update');
                    
                    });                
                });

                Route::group([  'prefix' => 'invoiceadresses', 'as' => 'invoiceadresses.'], function ()
                {
                    Route::get('', [OrdersController::class, 'invoiceAdressIndex'])->name('index');
                
                    Route::group([  'prefix' => '{orderadress}'], function ()
                    {
                        Route::get('edit', [OrdersController::class, 'invoiceAdressEdit'])->name('edit');
                        Route::post('update', [OrdersController ::class, 'invoiceAdressUpdate'])->name('update');

                    });
                });

                Route::group([  'prefix' => 'products', 'as' => 'products.'], function ()
                {
                    Route::get('', [OrdersController::class, 'productsIndex'])->name('index');
                    Route::post('store', [OrdersController::class, 'productsStore'])->name('store');
                    
                    Route::group([  'prefix' => '{orderdetail}'], function ()
                    {
                        Route::get('edit', [OrdersController::class, 'productsEdit'])->name('edit');
                        Route::post('update', [OrdersController::class, 'productsUpdate'])->name('update');
                        Route::delete('destroy', [OrdersController::class, 'productsDestroy'])->name('destroy');

                    });
                });

            });
        });

        Route::group([ 'prefix' => 'adresses', 'as' => 'adresses.'], function ()
        {
            Route::get('', [AdressesController::class, 'adminIndex'])->name('index');
            Route::get('create', [AdressesController::class, 'adminCreate'])->name('create');
            Route::post('store', [AdressesController::class, 'adminStore'])->name('store');
    
            Route::group([ 'prefix' => '{adress}'], function ()
            {
                Route::delete('destroy', [AdressesController::class, 'adminDestroy'])->name('destroy');
                Route::get('edit', [AdressesController::class, 'adminEdit'])->name('edit');
                Route::post('update', [AdressesController::class, 'adminUpdate'])->name('update');
            });

            Route::get('search', [AdressesController::class, 'searchIndex'])->name('search');
    
        });

        Route::group([ 'prefix' => 'products', 'as' => 'products.'], function ()
        {
     
            Route::get('', [ProductsController::class, 'adminIndex'])->name('index');
            Route::get('create', [ProductsController ::class, 'create'])->name('create');
            Route::post('store', [ProductsController ::class, 'store'])->name('store');
    
            Route::get('search', [ProductsController::class, 'searchIndex'])->name('search');

                Route::group([ 'prefix' => '{product}'], function ()
                {
                    Route::post('update', [ProductsController ::class, 'update'])->name('update');
                    Route::get('edit', [ProductsController::class, 'edit'])->name('edit');
                    Route::delete('destroy', [ProductsController::class, 'destroy'])->name('destroy');
                });

        });

        Route::group([ 'prefix' => 'productcategories', 'as' => 'productcategories.' ], function ()
        {
            Route::get('', [ProductCategoriesController::class, 'index'])->name('index');
            Route::get('create', [ProductCategoriesController ::class, 'create'])->name('create');
            Route::post('store', [ProductCategoriesController ::class, 'store'])->name('store');
                    
            Route::get('search', [ProductCategoriesController::class, 'searchIndex'])->name('search');

            Route::group([ 'prefix' => '{category}'], function ()
            {
                Route::post('update', [ProductCategoriesController ::class, 'update'])->name('update');
                Route::get('edit', [ProductCategoriesController::class, 'edit'])->name('edit');
                Route::delete('destroy', [ProductCategoriesController::class, 'destroy'])->name('destroy');
            });
        });

        Route::group([ 'prefix' => 'articles', 'as' => 'articles.'], function ()
        {
            Route::group([ 'prefix' => '{article}'], function ()
            {
                Route::get('edit', [ArticlesController::class, 'adminEdit'])->name('edit');
                Route::delete('destroy', [ArticlesController::class, 'adminDestroy'])->name('destroy');
                Route::post('update', [ArticlesController::class, 'adminUpdate'])->name('update');
            });

            Route::group([ 'prefix' => 'category'], function ()
            {
            Route::get('{category}', [ArticlesController::class, 'adminCategoriesShow']);
            });

            Route::get('', [ArticlesController::class, 'adminIndex'])->name('index');
            Route::get('create', [ArticlesController::class, 'adminCreate'])->name('create');
            Route::post('store', [ArticlesController::class, 'adminStore'])->name('store');

            Route::get('search', [ArticlesController::class, 'searchIndex'])->name('search');
        });

    Route::group([ 'prefix' => 'projects', 'as' => 'projects.'], function ()
    {
        Route::get('', [ProjectsController::class, 'adminIndex'])->name('index');
        Route::get('create', [ProjectsController::class, 'adminCreate'])->name('create');
        Route::post('store', [ProjectsController::class, 'adminStore'])->name('store');

        Route::get('search', [ProjectsController::class, 'searchIndex'])->name('search');

        Route::group([ 'prefix' => '{project}'], function ()
        {

            Route::post('update', [ProjectsController::class, 'adminUpdate'])->name('update');
            Route::get('edit', [ProjectsController::class, 'adminEdit'])->name('edit');
            Route::delete('destroy', [ProjectsController::class, 'adminDestroy'])->name('destroy');

            Route::get('members', [ProjectsController::class, 'adminMembersIndex'])->name('members');
            Route::get('roles', [ProjectsController::class, 'adminRolesIndex'])->name('roles');
            Route::get('opentasks', [ProjectsController::class, 'adminTasksOpenIndex'])->name('opentasks');
            Route::get('closedtasks', [ProjectsController::class, 'adminTasksClosedIndex'])->name('closedtasks');

            Route::group([ 'prefix' => 'roles', 'as' => 'roles.'], function ()
            {
                Route::post('store', [ProjectsController::class, 'adminRolesStore'])->name('store');

                Route::group([ 'prefix' => '{role}'], function ()
                {
                Route::get('edit', [ProjectsController::class, 'adminRolesEdit'])->name('edit');
                Route::post('update', [ProjectsController::class, 'adminRolesUpdate'])->name('update');
                Route::delete('destroy', [ProjectsController::class, 'adminRolesDestroy'])->name('destroy');
                });

                    Route::group([ 'prefix' => '{member}'], function ()
                    {
                        Route::get('membersedit', [ProjectsController::class, 'adminMembersEdit'])->name('membersedit'); 

                    });
            });

                Route::group([ 'prefix' => 'members', 'as' => 'members.'], function ()
                {
                    Route::get('create', [ProjectsController::class, 'create'])->name('memberscreate');
                    Route::post('store', [ProjectsController::class, 'adminMembersStore'])->name('membersstore');
                    Route::get('search', [ProjectsController::class, 'searchIndex'])->name('search');

                        Route::group([ 'prefix' => '{member}'], function ()
                        {

                        Route::get('edit', [ProjectsController::class, 'adminMembersEdit'])->name('membersedit');
                        Route::post('update', [ProjectsController::class, 'adminMembersUpdate'])->name('membersupdate');
                        Route::delete('destroy', [ProjectsController::class, 'adminMembersDestroy'])->name('destroy');
                        Route::get('membersedit', [ProjectsController::class, 'adminMembersEdit'])->name('membersedit'); 
                        Route::get('destroy', [ProjectsController::class, 'adminMembersDestroy'])->name('membersdestroy');
                        });
                });

                Route::group([ 'prefix' => 'tasks', 'as' => 'tasks.'], function ()
                {
                    Route::post('store', [ProjectsController::class, 'adminTasksStore'])->name('tasksstore'); 

                    Route::group([ 'prefix' => '{task}'], function ()
                    {
                        Route::get('complete', [ProjectsController::class, 'adminTasksComplete'])->name('taskscomplete');
                        Route::get('uncomplete', [ProjectsController::class, 'adminTasksUncomplete'])->name('tasksuncomplete');


                        Route::get('edit', [ProjectsController::class, 'adminTasksEdit'])->name('tasksedit');
                        Route::post('update', [ProjectsController::class, 'adminTasksUpdate'])->name('tasksupdate'); 
                        Route::delete('destroy', [ProjectsController::class, 'adminTasksDestroy'])->name('tasksdestroy');
                    
                    });

                    Route::group([ 'prefix' => '{status}'], function ()
                    {
                        Route::get('sortopenstatus', [ProjectsController::class, 'adminTasksOpenSortStatus'])->name('tasksopensortstatus');
                        Route::get('sortclosedstatus', [ProjectsController::class, 'adminTasksClosedSortStatus'])->name('tasksclosedsortstatus');


                    });

                    Route::group([ 'prefix' => '{member}'], function ()
                    {
                        Route::get('sortopenmember', [ProjectsController::class, 'adminTasksOpenSortMember'])->name('tasksopensortmember');
                        Route::get('sortclosedmember', [ProjectsController::class, 'adminTasksClosedSortMember'])->name('tasksclosedsortmember');

                    });
                });
        });
    });

    Route::group([ 'prefix' => 'categories', 'as' => 'categories.'], function ()
    {
 
        Route::get('', [CategoriesController::class, 'adminIndex'])->name('index');
        Route::get('create', [CategoriesController ::class, 'adminCreate'])->name('create');
        Route::post('store', [CategoriesController ::class, 'adminStore'])->name('store');

        Route::get('search', [CategoriesController::class, 'searchIndex'])->name('search');

            Route::group([ 'prefix' => '{category}'], function ()
            {
                Route::post('update', [CategoriesController ::class, 'adminUpdate'])->name('update');
                Route::get('edit', [CategoriesController::class, 'adminEdit'])->name('edit');
                Route::delete('destroy', [CategoriesController::class, 'adminDestroy'])->name('destroy');
            });

    });
    
    Route::group([ 'prefix' => 'users', 'as' => 'users.'], function ()
    {

        Route::get('', [UsersController::class, 'adminIndex'])->name('index');
        Route::get('create', [UsersController ::class, 'adminCreate'])->name('create');
        Route::post('store', [UsersController ::class, 'adminStore'])->name('store');

        Route::get('search', [UsersController::class, 'searchIndex'])->name('search');

            Route::group([ 'prefix' => '{user}'], function ()
            {
                Route::post('update', [UsersController ::class, 'adminUpdate'])->name('update');
                Route::get('edit', [UsersController::class, 'adminEdit'])->name('edit');
                Route::delete('destroy', [UsersController::class, 'adminDestroy'])->name('destroy');
            });
    });

    Route::group([ 'prefix' => 'roles', 'as' => 'roles.'], function ()
    {

        Route::get('', [RolesController::class, 'adminIndex'])->name('index');
        Route::get('create', [RolesController::class, 'adminCreate'])->name('create');
        Route::post('store', [RolesController::class, 'adminStore'])->name('store');

        Route::get('search', [RolesController::class, 'searchIndex'])->name('search');

        Route::group([ 'prefix' => '{role}'], function ()
        {
            Route::post('update', [RolesController::class, 'adminUpdate'])->name('update');
            Route::get('edit', [RolesController::class, 'adminEdit'])->name('edit');
            Route::delete('destroy', [RolesController::class, 'adminDestroy'])->name('destroy');
        });


    });

    Route::group([ 'prefix' => 'tasks', 'as' => 'tasks.'], function ()
    {
        Route::get('', [TasksController::class, 'adminIndex'])->name('index');
        Route::get('create', [TasksController::class, 'adminCreate'])->name('create');
        Route::post('store', [TasksController::class, 'adminStore'])->name('store');
        Route::get('completed', [TasksController::class, 'indexCompleted'])->name('completed');
        Route::get('uncompleted', [TasksController::class, 'indexUncompleted'])->name('uncompleted');

        Route::get('search', [TasksController::class, 'searchIndex'])->name('search');

        Route::get('user/{user}', [TasksController::class, 'usersIndex'])->name('user');

        Route::group([ 'prefix' => '{task}'], function ()
        {
            Route::get('complete', [TasksController::class, 'complete'])->name('complete');
            Route::get('uncomplete', [TasksController::class, 'uncomplete'])->name('uncomplete');

            Route::post('update', [TasksController::class, 'adminUpdate'])->name('update');
            Route::get('edit', [TasksController::class, 'adminEdit'])->name('edit');
            Route::delete('destroy', [TasksController::class, 'adminDestroy'])->name('destroy');
        });
    });

    Route::group([ 'prefix' => 'statuses', 'as' => 'statuses.'], function ()
    {
        Route::get('', [StatusesController::class, 'adminIndex'])->name('index');
        Route::get('create', [StatusesController::class, 'adminCreate'])->name('create');
        Route::post('store', [StatusesController::class, 'adminStore'])->name('store');

        Route::get('search', [StatusesController::class, 'searchIndex'])->name('search');

        Route::group([ 'prefix' => '{status}'], function ()
        {
        Route::post('update', [StatusesController::class, 'adminUpdate'])->name('update');
            Route::get('edit', [StatusesController::class, 'adminEdit'])->name('edit');
            Route::delete('destroy', [StatusesController::class, 'adminDestroy'])->name('destroy');
        });
    });
});

