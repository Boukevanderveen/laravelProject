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

Route::get('/secondpage', function () {
    return view('secondpage');
});

Route::get('/newrecord', function () {
    return view('newrecord');
});

// GET

Route::get('/', [AuthController::class, 'navigateToDashboard']);
Route::get('dashboard', [AuthController::class, 'navigateToDashboard']);
Route::get('login', [AuthController::class, 'loginView']);
Route::get('register', [AuthController::class, 'registerView']);
Route::get('/logout', [AuthController::class,"logout"]);
Route::get('/article/{id?}', [ArticlesController ::class, 'openArticle']);
Route::get('/article/{id?}/edit', [ArticlesController::class, 'openEditArticle']);
Route::get('/article/{id?}/edit', [ArticlesController::class, 'openEditArticle']);
Route::get('/manageusersview', [UsersController ::class, 'openManageUser']);
Route::get('/createarticleview', [ArticlesController ::class, 'openCreateArticle']);

// POST

Route::post('/finishlogin', [AuthController::class,"finishLogin"]);
Route::post('/finishregister', [AuthController::class,"finishRegister"]);
Route::post('/deletearticle', [ArticlesController ::class, 'deleteArticle']);
Route::post('/editarticle', [ArticlesController ::class, 'editArticle']);
Route::post('/removeadmin', [UsersController ::class, 'removeAdmin']);
Route::post('/makeadmin', [UsersController ::class, 'makeAdmin']);
Route::post('/createarticle', [ArticlesController ::class, 'createArticle']);
