<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Auth;


class TasksController extends Controller
{
    function adminIndex(Task $task)
    {
        $this->authorize('adminView', $task);

        $users = User::latest()->get();
        $tasks = Task::latest()->paginate(6);
        return view('admin.tasks.index', ['tasks' => $tasks, 'users' => $users]);
    }

    function indexCompleted(Task $task)
    {
        $this->authorize('view', $task);
        $users = User::latest()->get();
        $filter = "Sorteer op: voltooid";
        $tasks = Task::where('completed', 1)->latest()->paginate(6);
        return view('admin.tasks.index', ['tasks' => $tasks, 'task' => $task, 'filter' => $filter, 'users' => $users]);
    }

    function indexUncompleted(Task $task)
    {
        $this->authorize('view', $task);
        $users = User::latest()->get();
        $filter = "Sorteer op: open";
        $tasks = Task::where('completed', 0)->latest()->paginate(6);
        return view('admin.tasks.index', ['tasks' => $tasks, 'task' => $task, 'filter' => $filter, 'users' => $users]);
    }

    function adminCreate(Task $task)
    {
        $this->authorize('create', $task);
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();

        return view('admin.tasks.create', ['users' => $users, 'statuses' => $statuses, 'projects' => $projects]);
    }

    function adminStore(StoreTaskRequest $request, Task $task)
    {
        $project = Project::where('name','LIKE','%'.$request->project.'%')->first();
        $member = User::where('name','LIKE','%'.$request->member.'%')->first();
        $status = Status::where('name','LIKE','%'.$request->status.'%')->first();

        $this->authorize('create', $task);
        $Tasks = new Task;
        $Tasks->name = $request->name;
        $Tasks->description = $request->description;
        $Tasks->deadline = $request->deadline;
        $Tasks->project_id = $project->id;
        $Tasks->member_id = $member->id;
        $Tasks->status_id = $status->id;
        $Tasks->assigned_by_id = Auth::user()->id;
        $Tasks->completed = 0;
        $Tasks->save();
        return redirect('admin/tasks')->with('message', 'Taak succesvol gecreëerd');
    }
    
    function adminEdit(Task $task)
    {
        $this->authorize('update', $task);
        $users = User::All();
        $projects = Project::All();
        $statuses = Status::All();
        $project = Project::where('id', $task->project_id)->get();

        return view('admin.tasks.edit', ['task' => $task, 'member' => $task->member, 'users' => $users, 'statuses' => $statuses, 'projects' => $projects, 'project' => $project]);
    }

    function adminUpdate(UpdateTaskRequest $request, Task $task)
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

    function adminDestroy(Request $request, Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return back()->with('message', 'Taak succesvol verwijderd.');
    }

    function complete(Project $project, Task $task)
    {
        $this->authorize('update', $task);
        $task->completed = 1;
        $task->update();
        return back()->with('message', 'Taak succesvol afgerond.');
    }

    function uncomplete(Project $project, Task $task)
    {
        $this->authorize('update', $task);
        $task->completed = 0;
        $task->update();
        return back()->with('message', 'Taak succesvol onvoltooid.');;
    }

    public function searchIndex(Task $task, Request $request)
    {
        $this->authorize('view', $task);

        $users = User::latest()->get();
        $tasks = Task::where('name', 'like', '%' . $request->search_term.'%')
        ->latest()->paginate(6);

        return view('admin.tasks.index', ['tasks' => $tasks,'users' => $users, 'search_term' => $request->search_term]);
    }

    
}
