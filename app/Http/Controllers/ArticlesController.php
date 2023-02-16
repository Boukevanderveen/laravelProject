<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Article::class, 'Article');
    }

    function dashboardView()
    {
        $articles = Article::All();

        return view('dashboard', ['articles' => $articles]);
    }

    function articleView($id)
    {
        $article = Article::where('id', $id)->get();

        return view('article', ['article' => $article]);
    }

    function editView($id)
    {
        $article = Article::where('id', $id)->get();
        return view('editarticle', ['article' => $article]);
    }

    function createView()
    {
        return view('createarticle');
    }

    function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'content' => 'required', // required and number field validation

        ]); // create the validations
        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        } 
        else
        {
            $Articles = new Article;
            $Articles->title = $request->title;
            $Articles->description = $request->description;
            $Articles->content = $request->content;
            $author = Auth::user()->name;
            $Articles->author = $author;

            $Articles->save();

            return redirect('');   
        }
    }

    function delete(Request $request)
    {
        $query = Article::where('id', $request->articleid)->delete();

        if($query)
        {
            return redirect('');
        }
        else
        {
            //ERROR
        }
    }

    function edit(Request $request)
    {
        $query = Article::where('id', $request->id)->update(['title' => $request->title, 'description' => $request->description, 'content' => $request->content]);

        if($query)
        {
        return redirect('/article/'.$request->id.'');
        }
        else
        {
        }
    }
}
