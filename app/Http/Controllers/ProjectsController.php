<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\Project_User_Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;


class ProjectsController extends Controller
{
    function index()
    {
        $projects = Project::latest()->paginate(6);
        return view('admin.projects.index', ['projects' => $projects]);

    }
    
    function createView(Project $project)
    {
        if (auth()->user()->can('create', $project)) 
        {
            return view('admin.projects.create');
        }
        else
        {
            return redirect('/admin/projects');
        }
    }

    function updateView($id, Project $project)
    {
        if (auth()->user()->can('update', $project)) 
        {
            $users = User::All();

            $project = Project::find($id);
            $roles = Role::latest()->paginate(6);
            //$project->users()->attach(6);

            $users = User::select()
            ->whereNotIn('id', DB::table('Project_User_Role')->pluck('user_id'))
            ->get();

            dd($project->users);
            return view('admin.projects.update', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'users' => $users]);
        }
        else
        {
            return redirect('/admin/projects/');
        }
    }

    function rolesIndex(Project $project)
    {
        if (auth()->user()->can('update', $project)) 
        {
            $roles = Role::latest()->paginate(6);

            return view('admin.roles.index', ['roles' => $roles]);
        }
        else
        {
            return redirect('/admin/projects/');
        }
    }

    function membersIndex($id, Project $project)
    {
        if (auth()->user()->can('update', $project)) 
        {            
            $project = Project::find($id);
            $roles = Role::All();
            //$project->users()->attach(6);

            return view('admin.projects.members.index', ['members' => $project->users, 'project' => $project, 'roles' => $roles]);
        }
        else
        {
            return redirect('/admin/projects/');
        }
    }

    function membersUpdateView($id, $memberid, Project $project)
    {
        if (auth()->user()->can('update', $project)) 
        {
            $project = Project::find($id);
            $roles = Role::All();

            $member = User::where('id', $memberid)->first();
            return view('admin.projects.members.update', ['member' => $member, 'project' => $project, 'roles' => $roles]);
        }
        else
        {
            return redirect('/admin/projects/');
        }
    }

    function membersCreate($id, Request $request, Project $project)
    {
    
        if (auth()->user()->can('create', $project)) 
        {
            $project = Project::find($id);

            $user = User::where('name', $request->name)->first();
            $project->users()->attach($user->id);
            $project->roles()->attach($request->role);
            
            $user = User::find(1);
    
            return back()->with('message', 'Lid succesvol toegevoegd');
        

            return back()->with('error', 'Kon gebruiker niet toevoegen. Controleer of de gebruiker bestaat.');
                  
        }
        else
        {
            return back()->with('error', 'Geen rechten om een lid toe te voegen. Contacteer een administrateur');
        }
    }

    function membersUpdate(Request $request, Project $project)
    {
        if (auth()->user()->can('update', $project)) 
        {
            $project = Project::find($request->projectid);
            $user = User::where('id', $request->memberid)->first();
    
            dd($project);
            $project->users()->updateExistingPivot($user->id, [
                'role' => $request->role,
            ]);

            return back()->with('message', 'Lid rol succesvol bewerkt');
        }
        else
        {
            return redirect('/admin/projects')->with('error', 'Geen rechten om dit project te bewerken. Contacteer een administrateur.');

        }
    }

    

    function rolesMembersDelete($memberid, $projectid, Project $project)
    {
    if (auth()->user()->can('delete', $project)) 
    {
        $project = Project::find($projectid);
        $project->users()->detach($memberid);

        return back()->with('message', 'Lid succesvol verwijderd');
    }
    else
    {
        return back()->with('message', 'Geen rechten om dit lid te verwijderen. Contacteer een administrateur');
    }
    }


    function create(StoreProjectRequest $request, Project $project)
    {
        if (auth()->user()->can('create', $project)) 
        {
            $request->validated();

            $Projects = new Project;
            $Projects->name = $request->name;
            $Projects->description = $request->description;
            $Projects->creator = Auth::user()->name;
            
            $Projects->save();

            return redirect('admin/projects')->with('message', 'Project succesvol gecreëerd');

        }
        else
        {
            return redirect('admin/projects')->with('error', 'Geen rechten om een project te creëren. Contacteer een administrateur.');
        }
    }

    function update(UpdateProjectRequest $request, Project $project)
    {
        $request->validated();

        if (auth()->user()->can('update', $project)) 
        {
            $query = Project::where('id', $request->id)->update(['name' => $request->name, 'description' => $request->description]);
            if($query)
            {
                return redirect('admin/projects')->with('message', 'Project succesvol bewerkt.');
            }
            else
            {
                return redirect('admin/projects')->with('error', 'Er is een fout opgetreden met het bewerken van het project.');
            }
        }
        else
        {
            return redirect('/admin/projects')->with('error', 'Geen rechten om dit project te bewerken. Contacteer een administrateur.');

        }
    }

    function delete(Request $request, Project $project)
    {
        if (auth()->user()->can('delete', $project)) 
        {
            $query = Project::where('id', $request->id)->delete();
            if($query)
            {
                return redirect('/admin/projects')->with('message', 'Project succesvol verwijderd.');
            }
            else
            {
                return redirect('admin/projects')->with('error', 'Er is een fout opgetreden met het verwijderen van het project.');

            }
        }
        else
        {
            return redirect('/admin/projects')->with('error', 'Geen rechten om dit project te verwijderen. Contacteer een administrateur.');

        }
    }


}



