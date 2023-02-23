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

    function dashboardView()
    {
        $articles = Article::All();

        return view('articles/dashboard', ['articles' => $articles]);
    }

    function articleView($id)
    {
        $article = Article::where('id', $id)->get();

        return view('articles/article', ['article' => $article]);
    }

    function editView($id, Article $article)
    {
        if (auth()->user()->can('update', $article)) {
        $article = Article::where('id', $id)->get();
        return view('/articles/editarticle', ['article' => $article]);
        }
        else{
            return redirect('/articles/dashboard');
        }
    }

    function createView(Article $article)
    {
        if (auth()->user()->can('create', $article)) 
        {
            return view('articles/createarticle');
        }
        else
        {
            return redirect('');
        }
    }

    function create(Request $request, Article $article)
    {
        if (auth()->user()->can('create', $article)) {
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
    
                return redirect('home/articles');   
            }
            }
            else
            {
                //ERROR
            }
    }

    function delete(Request $request, Article $article)
    {
        if (auth()->user()->can('delete', $article)) 
        {
            $query = Article::where('id', $request->articleid)->delete();
            if($query)
            {
                return redirect('/home/articles');
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

    function update(Request $request, Article $article)
    {
        if (auth()->user()->can('update', $article)) 
        {
            $query = Article::where('id', $request->id)->update(['title' => $request->title, 'description' => $request->description, 'content' => $request->content]);
            if($query)
            {
                return redirect('articles/article/'.$request->id.'');
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
