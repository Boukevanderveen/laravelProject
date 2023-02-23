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
    function manageUserView(User $user)
    {
        if (auth()->user()->can('update', $user)) 
        {
            $users = User::All();
           
            return view('/users/manageusers', ['users' => $users]);
        }
        else
        {           
            return redirect('');
        }
    }

    function removeAdmin(Request $request, User $user)
    {
        if (auth()->user()->can('update', $user)) 
        {
            $query = User::where('id', $request->id)->update(['isAdmin' => 0]);
            if($query)
            {
            return redirect('/home/manageusers');
            }
            else
            {
                // ERROR
            }
        }
        else
        {
            return redirect('');
        }
    }

    function makeAdmin(Request $request, User $user)
    {
        if (auth()->user()->can('update', $user)) 
        {
            $query = User::where('id', $request->id)->update(['isAdmin' => 1]);
            if($query)
            {
            return redirect('/home/manageusers');
            }
            else
            {
                // ERROR
            }
        }
        else
        {
            return redirect('');
        }  
    }
}
