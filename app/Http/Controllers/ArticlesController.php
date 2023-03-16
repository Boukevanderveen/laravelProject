<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticlesController extends Controller
{

    function index()
    {
        $articles = Article::latest()->paginate(6);
        $categories = Category::all();

        return view('admin.articles.index', ['articles' => $articles, 'categories' => $categories]);
    }

    function updateView($id, Article $article)
    {
        if (auth()->user()->can('update', $article)) {
        $article = Article::where('id', $id)->get();
        $categories = Category::all();

        return view('admin.articles.update', ['article' => $article, 'categories' => $categories]);
        }
        else{
            return redirect('/admin/articles');
        }
    }

    function createView(Article $article)
    {
        
        if (auth()->user()->can('create', $article)) 
        {
            $categories = Category::all();

            return view('admin.articles.create', ['categories' => $categories]);

        }
        else
        {
            return redirect('');
        }
    }

    function viewCategory($category)
    {
        dd($category);
        $articles = Article::latest()->where('category', $category)->paginate(6);
        $categories = Category::all();

        return view('admin.articles.index', ['articles' => $articles, 'categories' => $categories]);


    }

    function create(StoreArticleRequest $request, Article $article)
    {
        if (auth()->user()->can('create', $article)) {

            $request->validated();

                $Articles = new Article;

                if($request->image)
                {
                $fileName = time().$request->file('image')->getClientOriginalName();
                
                $file = $request->file('image');
                $Articles->image = $fileName;
                }

                $Articles->title = $request->title;
                $Articles->description = $request->description;
                $Articles->content = $request->content;
                $Articles->author = Auth::user()->name;
                $Articles->category = $request->category;
                $Articles->published_at = $request->published_at;
                $Articles->save();
            
                $file->move(public_path('/images/articles/' . $Articles->id), $fileName);

                return redirect('admin/articles')->with('message', 'Artikel succesvol gecreëerd.'); 
            
            }
            else
            {
                return redirect('admin/articles')->with('error', 'Geen rechten om een artikel te creëren. Contacteer een administrateur.');
            }
    }

    function update(UpdateArticleRequest $request, Article $article)
    {
        $request->validated();

        if (auth()->user()->can('update', $article)) 
        {
            $query = Article::where('id', $request->id)->update(['title' => $request->title, 'description' => $request->description, 'content' => $request->content, 'category' => $request->category, 'published_at' => $request->published_at]);
            if($query)
            {
                return redirect('/admin/articles')->with('message', 'Artikel succesvol bewerkt.');
            }
            else
            {
                return redirect('/admin/articles')->with('error', 'Er is een fout opgetreden met het bewerken van het artikel.');
        
            }
        }
        else
        {
            return redirect('/admin/articles')->with('error', 'Geen rechten om dit artikel te bewerken. Contacteer een administrateur.');
        }
    }

    
    function delete(Request $request, Article $article)
    {
        if (auth()->user()->can('delete', $article)) 
        {
            $query = Article::where('id', $request->id)->delete();
            if($query)
            {
                return redirect('/admin/articles')->with('message', 'Artikel succesvol verwijderd.');
            }
            else
            {
                return redirect('/admin/articles')->with('error', 'Er is een fout opgetreden met het verwijderen van het artikel.');

            }
        }
        else
        {
            return redirect('/admin/articles')->with('error', 'Geen rechten om dit artikel te verwijderen. Contacteer een administrateur.');
        }
    }
}
