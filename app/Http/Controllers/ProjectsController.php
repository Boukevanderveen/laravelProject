<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\Project_User_Role;
use App\Models\Task;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class ProjectsController extends Controller
{
    function index(Project $project)
    {
        $projects = Project::latest()->paginate(6);
        return view('projects.index', ['projects' => $projects, 'project' => $project]);
    }
    
    function create(Project $project)
    {
        $this->authorize('create', $project);
        return view('projects.create');
    }

    function store(StoreProjectRequest $request, Project $project)
    {
        $this->authorize('create', $project);
        $Projects = new Project;
        $Projects->name = $request->name;
        $Projects->description = $request->description;
        $Projects->creator = Auth::user()->name;
        $Projects->save();
        return redirect('projects')->with('message', 'Project succesvol gecreëerd');
    }
    
    function edit(Project $project)
    {
        $this->authorize('update', $project);
        $users = User::All();
        $roles = Role::latest();
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User_Role')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->get();
        $closedTasks = Task::select()->where('completed', 1)->get();
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();

        return view('projects.edit', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects]);
    }

    function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $query = Project::where('id', $request->id)->update(['name' => $request->name, 'description' => $request->description]);
        if($query)
        {
            return redirect('projects')->with('message', 'Project succesvol bewerkt.');
        }
        else
        {
            return redirect('projects')->with('error', 'Er is een fout opgetreden met het bewerken van het project.');
        }
    }

    function destroy(Request $request, Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return back()->with('message', 'Project succesvol verwijderd.');
    }

    function rolesIndex(Project $project)
    {
        $this->authorize('update', $project);
        $roles = Role::latest()->paginate(6);
        return view('roles.index', ['roles' => $roles]);
    }

    function membersIndex($id, Project $project)
    {
        $this->authorize('update', $project);
        $project = Project::find($id);
        $roles = Role::All();
        return view('projects.members.index', ['members' => $project->users, 'project' => $project, 'roles' => $roles]);
    }

    function membersEdit($id, $memberid, Project $project)
    {
        $this->authorize('update', $project);
        $project = Project::find($id);
        $roles = Role::All();
        $member = User::where('id', $memberid)->first();
        return view('projects.members.edit', ['member' => $member, 'project' => $project, 'roles' => $roles]);
    }

    function membersStore(Request $request, Project $project)
    {
        $this->authorize('create', $project);
        $user = User::where('name', $request->name)->first();
        $project->users()->attach($user->id);
        $project->roles()->attach($request->role);
        $user = User::find(1);
        return back()->with('message', 'Lid succesvol toegevoegd');
    }

    function membersUpdate(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $project = Project::find($request->projectid);
        $user = User::where('id', $request->memberid)->first();
        $project->users()->updateExistingPivot($user->id, [
            'role' => $request->role,
        ]);
        return back()->with('message', 'Lid rol succesvol bewerkt');
    }

    

    function rolesMembersDelete($memberid, $projectid, Project $project)
    {
        $this->authorize('delete', $project);
        $project = Project::find($projectid);
        $project->users()->detach($memberid);
        return back()->with('message', 'Lid succesvol verwijderd');
    }

    function tasksStore(StoreTaskRequest $request, Task $task)
    {
        $this->authorize('create', $task);
        $Tasks = new Task;
        $Tasks->name = $request->name;
        $Tasks->description = $request->description;
        $Tasks->deadline = $request->deadline;
        $Tasks->project_id = $request->project;
        $Tasks->member_id = $request->assigned_to;
        $Tasks->status_id = $request->status;
        $Tasks->assigned_by_id = Auth::user()->id;
        $Tasks->completed = 0;
        $Tasks->save();
        return back()->with('message', 'Taak succesvol gecreëerd');
    }
    
    function tasksEdit(Project $project,Task $task)
    {
        $this->authorize('update', $task);
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();

        return view('projects.tasks.edit', ['task' => $task, 'member' => $task->member, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects, 'project' => $project]);
    }

    function tasksUpdate(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $this->authorize('update', $task);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->project_id = $request->project;
        $task->member_id = $request->assigned_to;
        $task->status_id = $request->status;
        $task->assigned_by_id = Auth::user()->id;
        $task->completed = $request->is_open;
        $task->update();
        return back()->with('message', 'Taak succesvol bewerkt.');
    }

    function tasksDestroy(Project $project,Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return back()->with('message', 'Taak succesvol verwijderd.');
    }

    function tasksComplete(Project $project, Task $task)
    {
        $this->authorize('update', $task);
        $task->completed = 1;
        $task->update();
        return back();
    }

    function tasksUncomplete(Project $project, Task $task)
    {
        $this->authorize('update', $task);
        $task->completed = 0;
        $task->update();
        return back();
    }

    function tasksSortStatus(Project $project, Status $status, Task $task)
    {
        $users = User::All();
        $roles = Role::latest();
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User_Role')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->where( 'status_id', $status->id)->get();
        $closedTasks = Task::select()->where('completed', 1)->where( 'status_id', $status->id)->get();
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();
        
        return view('projects.edit', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects, 'task' => $task]);

    }

    function tasksSortMember(Project $project, User $member, Task $task)
    {
        $users = User::All();
        $roles = Role::latest();
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User_Role')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->where( 'member_id', $member->id)->get();
        $closedTasks = Task::select()->where('completed', 1)->where( 'member_id', $member->id)->get();
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();
        
        return view('projects.edit', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects, 'task' => $task]);

    }

    function adminIndex()
    {
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
        $roles = Role::latest();
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User_Role')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->get();
        $closedTasks = Task::select()->where('completed', 1)->get();
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();

        return view('admin.projects.edit', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects]);
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
        $project->delete();
        return back()->with('message', 'Project succesvol verwijderd.');
    }

    function adminRolesIndex(Project $project)
    {
        $this->authorize('update', $project);
        $roles = Role::latest()->paginate(6);
        return view('admin.roles.index', ['roles' => $roles]);
    }

    function adminMembersIndex($id, Project $project)
    {
        $this->authorize('update', $project);
        $project = Project::find($id);
        $roles = Role::All();
        return view('admin.projects.members.index', ['members' => $project->users, 'project' => $project, 'roles' => $roles]);
    }

    function adminMembersEdit($id, $memberid, Project $project)
    {
        $this->authorize('update', $project);
        $project = Project::find($id);
        $roles = Role::All();
        $member = User::where('id', $memberid)->first();
        return view('admin.projects.members.edit', ['member' => $member, 'project' => $project, 'roles' => $roles]);
    }

    function adminMembersStore(Request $request, Project $project)
    {
        $this->authorize('create', $project);
        $user = User::where('name', $request->name)->first();
        $project->users()->attach($user->id);
        $project->roles()->attach($request->role);
        $user = User::find(1);
        return back()->with('message', 'Lid succesvol toegevoegd');
    }

    function adminMembersUpdate(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $project = Project::find($request->projectid);
        $user = User::where('id', $request->memberid)->first();
        $project->users()->updateExistingPivot($user->id, [
            'role' => $request->role,
        ]);
        return back()->with('message', 'Lid rol succesvol bewerkt');
    }

    

    function adminRolesMembersDelete($memberid, $projectid, Project $project)
    {
        $this->authorize('delete', $project);
        $project = Project::find($projectid);
        $project->users()->detach($memberid);
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
        $Tasks->member_id = $request->assigned_to;
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
        $this->authorize('update', $task);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->project_id = $request->project;
        $task->member_id = $request->assigned_to;
        $task->status_id = $request->status;
        $task->assigned_by_id = Auth::user()->id;
        $task->completed = $request->is_open;
        $task->update();
        return back()->with('message', 'Taak succesvol bewerkt.');
    }

    function adminTasksDestroy(Project $project,Task $task)
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

    function adminTasksSortStatus(Project $project, Status $status, Task $task)
    {
        $users = User::All();
        $roles = Role::latest();
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User_Role')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->where( 'status_id', $status->id)->get();
        $closedTasks = Task::select()->where('completed', 1)->where( 'status_id', $status->id)->get();
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();
        
        return view('admin.projects.edit', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects, 'task' => $task]);

    }

    function adminTasksSortMember(Project $project, User $member, Task $task)
    {
        $users = User::All();
        $roles = Role::latest();
        $usersProject = User::select()->whereNotIn('id', DB::table('Project_User_Role')->pluck('user_id'))->get();
        $openTasks = Task::select()->where('completed', 0)->where( 'member_id', $member->id)->get();
        $closedTasks = Task::select()->where('completed', 1)->where( 'member_id', $member->id)->get();
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();
        
        return view('admin.projects.edit', ['project' => $project, 'members' => $project->users, 'roles' => $roles, 'usersProject' => $usersProject, 'openTasks' => $openTasks, 'closedTasks' => $closedTasks, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects, 'task' => $task]);

    }
}



