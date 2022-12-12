<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Nodig voor queries
use Illuminate\Support\Facades\DB;
use App\Models\crud;

class laravelcrud extends Controller
{
    function index()
    {
        return view('dashboard');
    }

    function add(Request $request)
    {
        //Ingestelde verplichte input
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:crud',
        ]);

        $query = DB::table('crud')->insert([ 

            'name'=>$request->input('name'),
            'email'=>$request->input('email')
        ]);

        if($query)
        { 
            return back()->with('succes','the data has succesfully been inserted'); 
        } 
        else 
        { 
            return back()->with('fail','something went wrong');
        }
    }

    function navigatetoMenu()
    {
        $records = crud::all();
        return view("menu", ["records"=>$records]);
    }

    function navigatetoEdit()
    {
        return view("dashboard", ["posts"=>$posts]);

    }

    function update(Request $request)
    {
        //Ingestelde verplichte input
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:crud',
        ]);

        $query = DB::table('crud')->insert([ 

            'name'=>$request->input('name'),
            'email'=>$request->input('email')
        ]);

        if($query)
        { 
            return back()->with('succes','the data has succesfully been update'); 
        } 
        else 
        { 
            return back()->with('fail','something went wrong');
        }
    }
}
