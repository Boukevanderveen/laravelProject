<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Auth;

class UsersController extends Controller
{
    function openManageUser()
    {
    if(Auth::Check())
    {
        if (Auth::user()->isAdmin == 1)
        {
            $users = DB::table("users")->get();
           
            return view('manageusers', ['users' => $users]);
        }
        else
        {
            $articles = DB::table("articles")->where("author", "=", "iemand")->get();
           
            return view('dashboard', ['articles' => $articles]);
        }
    }
    else
    {
        $articles = DB::table("articles")->where("author", "=", "iemand")->get();
           
        return view('dashboard', ['articles' => $articles]);  
    }
    }

    function removeAdmin(Request $request)
    {
        $query = DB::table('users')->where('id', $request->id)->update(['isAdmin' => 0]);
        if($query)
        {
        return redirect('/manageusersview');
        }
        else
        {
            // ERROR
        }
    }

    function makeAdmin(Request $request)
    {
        $query = DB::table('users')->where('id', $request->id)->update(['isAdmin' => 1]);
        if($query)
        {
        return redirect('/manageusersview');
        }
        else
        {
            // ERROR
        }
    }
}
