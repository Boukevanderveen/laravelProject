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

Route::get('/newrecord', function () {
    return view('newrecord');
});

Route::get('/dm', function () {
    return view('dm');
});



// GET

Route::get('/', [FriendsController::class, 'navigateToDashboard']);
Route::get('dashboard', [FriendsController::class, 'navigateToDashboard']);
Route::get('menu', [laravelcrud::class, 'navigatetoMenu']);
Route::get('crud', [laravelcrud::class, 'index']);
Route::get('login', [AuthController::class, 'loginView']);
Route::get('register', [AuthController::class, 'registerView']);
Route::get('/logout', [AuthController::class,"logout"]);
Route::get('/sendfriendrequest', [FriendsController::class,"navigatetosendfriendrequest"]);
Route::get('friendrequests', [FriendsController::class, 'navigatetoFriendRequests']);
Route::get('friendslist', [FriendsController::class, 'navigatetoFriendsList']);
Route::get('dm', [MessagesController::class, 'navigateToDM']);

// POST

Route::post('add', [laravelcrud::class, 'add']);
Route::post('navigatetoedit', [laravelcrud::class, 'navigatetoedit']);
Route::post('/finishlogin', [AuthController::class,"finishLogin"]);
Route::post('/finishregister', [AuthController::class,"finishRegister"]);
Route::post('/sendfriendrequestdata', [FriendsController::class, 'sendfriendrequest']);
Route::post('/acceptfriendreq', [FriendsController::class, 'acceptFriendRequest']);
Route::post('/declinefriendreq', [FriendsController::class, 'declineFriendRequest']);
Route::post('/deletefriendreq', [FriendsController::class, 'deleteFriendRequest']);
Route::post('/DM', [MessagesController::class, 'navigateToDM']);

Route::post('/sender', [MessagesController::class, 'insertMessageInDB']);


