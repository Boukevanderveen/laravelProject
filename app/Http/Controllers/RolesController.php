<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\Project_User;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;


class RolesController extends Controller
{

    function adminIndex(Role $role)
    {
        $this->authorize('adminView', $role);

        $roles = Role::latest()->paginate(6);
        return view('admin.roles.index', ['roles' => $roles]);
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
        try {
            $this->authorize('delete', $role);
            $role->delete();
            return back()->with('message', 'Rol succesvol verwijderd.');

          } catch (\Exception $e) {
            return back()->with('error', 'Rol kon niet worden verwijderd. Controleer of een gebruiker deze rol nog gebruikt.');
          }
    }

    public function searchIndex(Role $role, Request $request)
    {
        $this->authorize('view', $role);

        $roles = Role::where('name', 'like', '%' . $request->search_term.'%')
        ->latest()->paginate(6);

        return view('admin.roles.index', ['roles' => $roles, 'search_term' => $request->search_term]);
    }
}
