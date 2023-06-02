<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\Task;
use App\Models\Status;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class ProjectsController extends Controller
{
    function index(Project $project)
    {
        $projects = Project::latest()->paginate(6);
        return view('projects.index', ['projects' => $projects, 'project' => $project]);
    }
    
    function show(Project $project)
    {
        return view('projects.show', ['project' => $project]);
    } 

    function adminIndex(Project $project)
    {
        $this->authorize('adminView', $project);

        $projects = Project::latest()->paginate(6);
        return view('admin.projects.index', ['projects' => $projects]);
    }
    
    function adminCreate(Project $project)
    {
        $this->authorize('create', $project);
        return view('admin.projects.create');
    }

    function adminStore(StoreProjectRequest $request, Project $project)
    {
        $this->authorize('create', $project);
        $Projects = new Project;
        $Projects->name = $request->name;
        $Projects->description = $request->description;
        $Projects->creator = Auth::user()->name;
        $Projects->save();
        return redirect('admin/projects')->with('message', 'Project succesvol gecreëerd');
    }
    
    function adminEdit(Project $project)
    {
        $this->authorize('update', $project);
        $users = User::All();
        $roles = Role::latest()->paginate(6);
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->get();
        $closedTasks = Task::select()->where('completed', 1)->get();

        $users = User::All();
        $statuses = Status::All();

        return view('admin.projects.edit', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses]);
    }

    function adminMembersIndex(Project $project)
    {
        $this->authorize('update', $project);
        $users = User::All();
        $roles = Role::latest()->paginate(6);
        
        $userproject = ProjectUser::where('project_id', $project->id)->get();

        $usersProject = User::select()->whereNotIn('id', $userproject->pluck('user_id'))->get();

        $users = User::All();
        $statuses = Status::All();

        return view('admin.projects.members.index', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'users' => $users, 'statuses' => $statuses]);
    }

    function adminRolesIndex(Project $project)
    {
        $this->authorize('view', $project);
        $users = User::All();
        $roles = Role::latest()->paginate(6);
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User')->pluck('user_id'))->get();
        return view('admin.projects.roles.index', ['project' => $project, 'usersProject' => $usersProject, 'roles' => $roles]);
    }

    function adminRolesStore(StoreRoleRequest $request, Project $project, Role $role)
    {
        $this->authorize('create', $role);
        $Role = new Role;
        $Role->name = $request->name;
        $Role->save();
        return back()->with('message', 'Rol succesvol gecreëerd');
    }

    function adminRolesEdit(Project $project, Role $role)
    {
        $this->authorize('update', $role);
        return view('admin.projects.roles.edit', ['role' => $role, 'project' => $project]);
    }

    function adminRolesUpdate(UpdateRoleRequest $request, Project $project, Role $role)
    {
        $this->authorize('update', $role);
        $role->name = $request->name;
        $role->update();
        return back()->with('message', 'Rol succesvol bewerkt.');
    }

    function adminRolesDestroy(Project $project, Role $role)
    {
        try {
            $this->authorize('delete', $role);
            $role->delete();
            return back()->with('message', 'Rol succesvol verwijderd.');

          } catch (\Exception $e) {
            return back()->with('error', 'Rol kon niet worden verwijderd. Controleer of een gebruiker deze rol nog gebruikt.');
          }
    }
    function adminTasksOpenIndex(Project $project)
    {
        $this->authorize('update', $project);
        $users = User::All();
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->get();
        $users = User::All();
        $statuses = Status::All();

        return view('admin.projects.tasks.opentasks', ['project' => $project, 'members' => $project->users, 'usersProject' => $usersProject, 'users' => $users, 'statuses' => $statuses, 'openTasks' => $openTasks]);
    }

    function adminTasksClosedIndex(Project $project)
    {
        $this->authorize('update', $project);
        $users = User::All();
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User')->pluck('user_id'))->get();
        $closedTasks = Task::select()->where('completed', 1)->get();
        $users = User::All();
        $statuses = Status::All();

        return view('admin.projects.tasks.closedtasks', ['project' => $project, 'members' => $project->users, 'usersProject' => $usersProject, 'users' => $users, 'statuses' => $statuses, 'closedTasks' => $closedTasks]);
    }

    function adminUpdate(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
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

    function adminDestroy(Request $request, Project $project)
    {
        $this->authorize('delete', $project);        
        $projectTasks = Task::where('project_id', $project->id);
        $projectTasks->delete();
        $projectMembers = ProjectUser::where('project_id', $project->id);
        $projectMembers->delete();
        $project->delete();
        return back()->with('message', 'Project succesvol verwijderd.');
    }

    function adminMembersStore(Request $request, Project $project)
    {
        $this->authorize('create', $project);
        $user = User::where('id', $request->userid)->first();
        $role = Role::where('id', $request->roleid)->first();
        $project->users()->attach($user, ['role_id' => $role->id]);
        return back()->with('message', 'Lid succesvol toegevoegd');
    }

    function adminMembersEdit(Project $project, User $member)
    {
        $this->authorize('update', $project);
        $roles = Role::All();
        return view('admin.projects.members.edit', ['member' => $member, 'project' => $project, 'roles' => $roles]);
    }

    function adminMembersUpdate(Request $request, Project $project)
    {
        $this->authorize('update', $project);

            $user = User::find($request->user);
            $project->users()->updateExistingPivot($user, array('role_id' => $request->role), false);
        

        //$project->users()->attach($user, ['role_id' => $role->id]);
        /*
        $project = Project::find($request->projectid);
        $user = User::where('id', $request->memberid)->first();
        $project->users()->updateExistingPivot($user->id, [
            'role' => $request->role,
        ]);
        */
        return back()->with('message', 'Lid rol succesvol bewerkt');
    }


    function adminMembersDestroy(Project $project, User $member)
    {
        $this->authorize('delete', $project);
        $project->users()->detach($member->id);
        return back()->with('message', 'Lid succesvol verwijderd');
    }

    function adminTasksStore(StoreTaskRequest $request, Task $task)
    {
        $this->authorize('create', $task);
        $Tasks = new Task;
        $Tasks->name = $request->name;
        $Tasks->description = $request->description;
        $Tasks->deadline = $request->deadline;
        $Tasks->project_id = $request->project;
        $Tasks->member_id = $request->member;
        $Tasks->status_id = $request->status;
        $Tasks->assigned_by_id = Auth::user()->id;
        $Tasks->completed = 0;
        $Tasks->save();
        return back()->with('message', 'Taak succesvol gecreëerd');
    }
    
    function adminTasksEdit(Project $project,Task $task)
    {
        $this->authorize('update', $task);
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();

        return view('admin.projects.tasks.edit', ['task' => $task, 'member' => $task->member, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects, 'project' => $project]);
    }

    function adminTasksUpdate(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $project = Project::where('name','LIKE','%'.$request->project.'%')->first();
        $member = User::where('name','LIKE','%'.$request->member.'%')->first();
        $status = Status::where('name','LIKE','%'.$request->status.'%')->first();

        $this->authorize('update', $task);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->project_id = $project->id;
        $task->member_id = $member->id;
        $task->status_id = $status->id;
        $task->assigned_by_id = Auth::user()->id;
        $task->completed = $request->completed;
        $task->update();
        return back()->with('message', 'Taak succesvol bewerkt.');
    }

    function adminTasksDestroy(Project $project, Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return back()->with('message', 'Taak succesvol verwijderd.');
    }

    function adminTasksComplete(Project $project, Task $task)
    {
        $this->authorize('update', $task);
        $task->completed = 1;
        $task->update();
        return back();
    }

    function adminTasksUncomplete(Project $project, Task $task)
    {
        $this->authorize('update', $task);
        $task->completed = 0;
        $task->update();
        return back();
    }

    function adminTasksOpenSortStatus(Project $project, Status $status, Task $task)
    {
        $users = User::All();
        $roles = Role::latest();

        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User')->pluck('user_id'))->get();
        $openTasks = Task::where('status_id', $status->id)->where('completed', 0)->get();
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();
        
        return view('admin.projects.tasks.opentasks', ['status' => $status, 'project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'users' => $users, 'statuses' => $statuses, 'task' => $task]);

    }

    function adminTasksOpenSortMember(Project $project, User $member, Task $task)
    {
        $users = User::All();
        $roles = Role::latest();
        $usersProject = User::select()->whereNotIn('id', DB::table('project_user')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->where( 'member_id', $member->id)->get();
        $users = User::All();
        $statuses = Status::All();
        
        return view('admin.projects.tasks.opentasks', ['member' => $member, 'project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'users' => $users, 'statuses' => $statuses, 'task' => $task]);

    }

    function adminTasksClosedSortStatus(Project $project, Status $status, Task $task)
    {
        $users = User::All();
        $roles = Role::latest();

        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User')->pluck('user_id'))->get();
        $closedTasks = Task::where('status_id', $status->id)->where('completed', 1)->get();
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();
        
        return view('admin.projects.tasks.closedtasks', ['status' => $status, 'project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses, 'task' => $task]);

    }

    function adminTasksClosedSortMember(Project $project, User $member, Task $task)
    {
        $users = User::All();
        $roles = Role::latest();
        $usersProject = User::select()->whereNotIn('id', DB::table('project_user')->pluck('user_id'))->get();
        $closedTasks = Task::select()->where('completed', 1)->where( 'member_id', $member->id)->get();
        $users = User::All();
        $statuses = Status::All();
        
        return view('admin.projects.tasks.closedtasks', ['member' => $member, 'project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses, 'task' => $task]);

    }

    public function searchIndex(Project $project, Request $request)
    {
        $this->authorize('view', $project);
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User')->pluck('user_id'))->get();


        // 'projects' is functie in model User
        $statuses = Status::All();
        $roles = Role::All();
        $users = User::where('name', 'like', '%' . $request->search_term.'%')->whereRelation('projects', 'project_id', $project->id)->get();
        //$projects = Project::all();
        //$projects = Project::with('users')->whereRelation('users', 'name', 'like', '%' . $request->search_term)->latest()->
                                            //paginate();

        return view('admin.projects.members.index', ['members' => $users, 'project' => $project, 'search_term' => $request->search_term, 'usersProject' => $usersProject, 'statuses' => $statuses, 'roles' => $roles]);
    }

}



