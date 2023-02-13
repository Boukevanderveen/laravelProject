<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravelcrud;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\FriendsController;
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

Route::get('/dm', function () {
    return view('dm');
});


// GET

Route::get('/', [AuthController::class, 'navigateToDashboard']);
Route::get('dashboard', [AuthController::class, 'navigateToDashboard']);
Route::get('login', [AuthController::class, 'loginView']);
Route::get('register', [AuthController::class, 'registerView']);
Route::get('/logout', [AuthController::class,"logout"]);

// POST

Route::post('/finishlogin', [AuthController::class,"finishLogin"]);
Route::post('/finishregister', [AuthController::class,"finishRegister"]);
