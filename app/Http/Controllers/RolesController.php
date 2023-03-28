<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\Project_User_Role;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;


class RolesController extends Controller
{
    function index(Role $role)
    {
        $this->authorize('update', $role);
        $roles = Role::latest()->paginate(6);
        return view('roles.index', ['roles' => $roles, 'role' => $role]);
    }

    function create(Role $role)
    {
        $this->authorize('create', $role);
        return view('roles.create');
    }

    function store(StoreRoleRequest $request, Role $role)
    {
        $this->authorize('create', $role);
        $Role = new Role;
        $Role->name = $request->name;
        $Role->save();
        return redirect('roles')->with('message', 'Rol succesvol gecreëerd');
    }
    
    function edit(Role $role)
    {
        $this->authorize('update', $role);
        return view('roles.edit', ['role' => $role]);
    }

    function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        $role->name = $request->name;
        $role->save();
        return redirect('roles')->with('message', 'Rol succesvol bewerkt.');
    }

    function destroy(Request $request, Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
        return back()->with('message', 'Rol succesvol verwijderd.');
    }

    function adminCreate(Role $role)
    {
        $this->authorize('create', $role);
        return view('admin.roles.create');
    }

    function adminStore(StoreRoleRequest $request, Role $role)
    {
        $this->authorize('create', $role);
        $Role = new Role;
        $Role->name = $request->name;
        $Role->save();
        return redirect('admin/roles')->with('message', 'Rol succesvol gecreëerd');
    }
    
    function adminEdit(Role $role)
    {
        $this->authorize('update', $role);
        return view('admin.roles.edit', ['role' => $role]);
    }

    function adminUpdate(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        $role->name = $request->name;
        $role->save();
        return redirect('admin/roles')->with('message', 'Rol succesvol bewerkt.');
    }

    function adminDestroy(Request $request, Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
        return back()->with('message', 'Rol succesvol verwijderd.');
    }
}
