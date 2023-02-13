<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    function createArticle(Request $request)
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

            return redirect('/');   
        }
    }

    function baseRedirect()
    {
        $articles = DB::table("articles")->where("author", "=", "iemand")->get();
           
        return view('dashboard', ['articles' => $articles]);
    }

    function deleteArticle(Request $request)
    {
        $query = DB::table('articles')->where('id', $request->articleid)->delete();
        if($query)
        {
            $articles = Article::All();
            return redirect('/');
        }
        else
        {
            //ERROR
        }
    }

    function openArticle($id)
    {
            $article = DB::table('articles')->where('id', $id)->get();
            return view('article', ['article' => $article]);
    }

    function openEditArticle($id)
    {
            $article = DB::table('articles')->where('id', $id)->get();
            return view('editarticle', ['article' => $article]);
    }

    function openCreateArticle()
    {
            return view('createarticle');
    }

    function editArticle(Request $request)
    {
            $query = DB::table('articles')->where('id', $request->id)->update(['title' => $request->title, 'description' => $request->description, 'content' => $request->content]);
            if($query)
            {
            return redirect('/article/'.$request->id.'');
            }
            else
            {
            }
    }
}
