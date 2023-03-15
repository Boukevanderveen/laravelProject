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
    function createView(Role $role)
    {
        if (auth()->user()->can('create', $role)) 
        {
            return view('admin.roles.create');
        }
        else
        {
            return redirect('/admin/projects');
        }
    }

    function updateView($id, Role $role)
    {
        if (auth()->user()->can('update', $role)) 
        {
            $role = Role::where('id', $id)->get();

            return view('admin.roles.update', ['role' => $role]);
        }
        else
        {
            return redirect('/admin/projects/');
        }
    }

    function create(StoreRoleRequest $request, Role $role)
    {

        if (auth()->user()->can('create', $role)) 
        {
            $request->validated();

                $Role = new Role;
                $Role->name = $request->name;
                
                $Role->save();
    
                return redirect('admin/roles')->with('message', 'Rol succesvol gecreëerd');
        }
        else
        {
            return back()->with('error', 'Geen rechten om een project te creëren. Contacteer een administrateur.');
        }
    }

    function update(UpdateRoleRequest $request, Role $role)
    {
        if (auth()->user()->can('update', $role)) 
        {
            $request->validated();
    
            $query = Role::where('id', $request->id)->update(['name' => $request->name]);
            if($query)
            {
                return redirect('admin/roles')->with('message', 'Rol succesvol bewerkt.');
            }
            else
            {
                return back()->with('error', 'Er is een fout opgetreden met het bewerken van de rol.');
            }
        }
        else
        {
            return back()->with('error', 'Geen rechten om deze rol te bewerken. Contacteer een administrateur.');

        }
    }

    function delete(Request $request, Role $role)
    {
        if (auth()->user()->can('delete', $role)) 
        {
            $query = Role::where('id', $request->id)->delete();
            if($query)
            {
                return back()->with('message', 'Rol succesvol verwijderd.');
            }
            else
            {
                return back()->with('error', 'Er is een fout opgetreden met het verwijderen van de rol.');

            }
        }
        else
        {
            return back()->with('error', 'Geen rechten om deze rol te verwijderen. Contacteer een administrateur.');

        }
    }
}
