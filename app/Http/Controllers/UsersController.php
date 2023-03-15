<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;


class UsersController extends Controller
{
    function adminView(User $user)
    {
        if (auth()->user()->can('update', $user)) 
        {
            $users = User::latest()->paginate(6);
           
            return view('/users/admin/users', ['users' => $users]);
        }
        else
        {           
            return redirect('');
        }
    }

    function createView()
    {
        return view('users.admin.createuser');
    }

    function updateView($id, User $user)
    {
        if (auth()->user()->can('update', $user)) {
            $user = User::where('id', $id)->get();
            return view('users/admin/edituser', ['user' => $user]);
            }
            else{
                return redirect('/admin/users');
        }
    }

    function create(StoreUserRequest $request)
    {
        $request->validated();

        $User = new User;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->password = bcrypt($request->password);
        $User->isAdmin = 0;
        $User->isOwner = 0;

        $User->save();

        return redirect('/admin/users');

    }

    function update(UpdateUserRequest $request, User $user)
    {
        $request->validated();

        if (auth()->user()->can('update', $user)) 
        {
            $query = User::where('id', $request->id)->update(['name' => $request->name, 'email' => $request->email, 'password' => $request->password]);
            if($query)
            {
                return redirect('/admin/users')->with('message', 'Gebruiker succesvol bewerkt.');
            }
            else
            {
                return redirect('/admin/users')->with('error', 'Er is een fout opgetreden met het bewerken van de gebruiker.');
        
            }
        }
        else
        {
            return redirect('/admin/users')->with('error', 'Geen rechten om deze gebruiker te bewerken. Contacteer een administrateur.');
        }
    }

    
    function delete(Request $request, User $user)
    {
        if (auth()->user()->can('delete', $user))
        {
            $query = User::where('id', $request->id)->delete();
            if($query)
            {
                return redirect('/admin/users')->with('message', 'Gebruiker succesvol verwijderd.');;
            }
            else
            {

                return redirect('/admin/users')->with('error', 'Geen rechten om een gebruiker te verwijderen. Contacteer een administrateur.'); 
            }
        }
        else
        {
            return redirect('/admin/users')->with('error', 'Er is een fout opgetreden met het verwijderen van deze gebruiker.'); 

        }
    }

    function makeAdmin($id, User $user)
    {
        if (auth()->user()->can('update', $user)) 
        {
            $query = User::where('id', $id)->update(['isAdmin' => 1]);
            if($query)
            {
                $user = User::where('id', $id)->get();

                return view('users.admin.edituser', ['user' => $user] );
            }
            else
            {

            }
        }
        else
        {

        }  
    }

    function removeAdmin($id, User $user)
    {
        if (auth()->user()->can('update', $user)) 
        {
            $query = User::where('id', $id)->update(['isAdmin' => 0]);
            if($query)
            {
                $user = User::where('id', $id)->get();

                return view('users.admin.edituser', ['user' => $user] );            }
            else
            {
            }
        }
        else
        {

        }
    }
}
