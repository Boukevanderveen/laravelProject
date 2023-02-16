<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;


class ProjectsController extends Controller
{
    function view()
    {
        $projects = Project::All();
        return view('projects', ['projects' => $projects]);

    }
    
    function createView()
    {
        return view('createproject');
    }

    function create(Request $request)
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

            return redirect('projects');   
        }
    }
}
