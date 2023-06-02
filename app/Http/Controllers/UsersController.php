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
    function index(User $user)
    {
        $this->authorize('update', $user);
        $users = User::latest()->paginate(6);
        return view('users.index', ['users' => $users]);
    }

    function create()
    {
        return view('users.create');
    }

    function edit($id, User $user)
    {
        $this->authorize('update', $user);
        $user = User::where('id', $id)->get();
        return view('users.edit', ['user' => $user]);
    }

    function store(StoreUserRequest $request)
    {
        $User = new User;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->password = bcrypt($request->password);
        $User->isAdmin = 0;
        $User->isOwner = 0;
        $User->save();
        return redirect('/users');
    }

    function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->isadmin = 0;
        $user->isowner = 0;
        $user->update();
        return redirect('/users')->with('message', 'Gebruiker succesvol bewerkt.');
    }

    function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return back()->with('message', 'Gebruiker succesvol verwijderd.');
    }

    function adminIndex(User $user)
    {
        $this->authorize('adminView', $user);

        $this->authorize('update', $user);
        $users = User::latest()->paginate(6);
        return view('admin.users.index', ['users' => $users]);
    }

    function adminCreate()
    {
        return view('admin.users.create');
    }

    function adminEdit(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.users.edit', ['user' => $user]);
    }

    function adminStore(StoreUserRequest $request)
    {
        $User = new User;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->password = bcrypt($request->password);
        $User->isAdmin = $request->isadmin;
        $User->isOwner = 0;
        $User->save();
        return redirect('/admin/users');
    }

    function adminUpdate(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)) {
        $user->password = bcrypt($request->password);
        }
        $user->isAdmin = $request->isadmin;
        $user->update();
        return redirect('/admin/users')->with('message', 'Gebruiker succesvol bewerkt.');
    }

    function adminDestroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);
        try {
            $user->delete();
            return back()->with('message', 'Gebruiker succesvol verwijderd.');
          } catch (\Exception $e) {
            return back()->with('error', 'Er is iets mis gegaan bij het verwijderen van deze gebruiker.');
          }
    }

    public function searchIndex(User $user, Request $request)
    {
        $this->authorize('view', $user);

        $users = User::where('name', 'like', '%' . $request->search_term.'%')
        ->latest()->paginate(6);

        return view('admin.users.index', ['users' => $users, 'search_term' => $request->search_term]);
    }
}
