<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;


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

    function editView($id, Project $project)
    {
        if (auth()->user()->can('update', $project)) 
        {
            $project = Project::where('id', $id)->get();

            return view('admin.projects.update', ['project' => $project]);
        }
        else
        {
            return redirect('/admin/projects/');
        }
    }

    function create(Request $request, Project $project)
    {
        if (auth()->user()->can('create', $project)) 
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'description' => 'required', // required and number field validation
    
            ]); // create the validations
            if ($validator->fails())
            {
                return back()->withInput()->withErrors($validator);
            } 
            else
            {
                $Projects = new Project;
                $Projects->name = $request->name;
                $Projects->description = $request->description;
                $Projects->creator = Auth::user()->name;
                
                $Projects->save();
    
                return redirect('admin/projects')->with('message', 'Project succesvol gecreëerd');

            }
        }
        else
        {
            return redirect('admin/projects')->with('error', 'Geen rechten om een project te creëren. Contacteer een administrateur.');
        }
    }

    function update(Request $request, Project $project)
    {
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
