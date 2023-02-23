<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;


class ProjectsController extends Controller
{
    function view()
    {
        $projects = Project::All();
        return view('projects/projects', ['projects' => $projects]);

    }
    
    function createView(Project $project)
    {
        if (auth()->user()->can('create', $project)) 
        {
            return view('projects/createproject');
        }
        else
        {
            return redirect('/home/projects');
        }
    }
    
    function projectView($id)
    {
        
        $project = Project::where('id', $id)->get();

        return view('projects/project', ['project' => $project]);
        
    }

    function editView($id, Project $project)
    {
        if (auth()->user()->can('update', $project)) 
        {
            $project = Project::where('id', $id)->get();

            return view('projects/editproject', ['project' => $project]);
        }
        else
        {
            return redirect('/projects/project/'.$id.'');
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
    
                return redirect('home/projects');   
            }
        }
        else
        {
            return redirect('/home/projects');
        }
    }

    function update(Request $request, Project $project)
    {
        if (auth()->user()->can('update', $project)) 
        {
            $query = Project::where('id', $request->id)->update(['name' => $request->name, 'description' => $request->description]);
            if($query)
            {
                return redirect('projects/project/'.$request->id.'');
            }
            else
            {
                //ERROR
            }
        }
        else
        {
                //ERROR
        }
    }

    function delete(Request $request, Project $project)
    {
        if (auth()->user()->can('delete', $project)) 
        {
            $query = Project::where('id', $request->id)->delete();
            if($query)
            {
                return redirect('/home/projects');
            }
            else
            {
                //ERROR
            }
        }
        else
        {
            //ERROR
        }
    }
}
