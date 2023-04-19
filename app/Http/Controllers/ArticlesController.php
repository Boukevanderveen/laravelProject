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

    function index(Article $article)
    {
        $articles = Article::latest()->paginate(6);
        $categories = Category::all();
        // compact('variable', 'variable')
        return view('articles.index', ['articles' => $articles, 'categories' => $categories, 'article' => $article]);
    }

    function show(Article $article)
    {
        $this->authorize('viewAny', $article);

        return view('articles.show', ['article' => $article]);
    }

    function create(Article $article)
    {
        $this->authorize('create', $article);

        $categories = Category::all();
        return view('articles.create', ['categories' => $categories]);
    }

    function store(StoreArticleRequest $request, Article $article)
    {
        $this->authorize('create', $article);

        $Articles = new Article;
        if ($request->hasFile('image')) 
        {
            $fileName = time() . '.' . $request->image->extension();
            $file = $request->file('image');
            $file->move(public_path('/images/articles/' . $Articles->id), $fileName);
                        //$Articles->image = $fileName;

            

            //$fileName = time().$request->file('image')->getClientOriginalName();
                
                //$Articles->image = $fileName;

        }
        $Articles->title = $request->title;
        $Articles->description = $request->description;
        $Articles->content = $request->content;
        $Articles->author = Auth::user()->name;
        $Articles->category = $request->category;
        $Articles->published_at = $request->published_at;
        $Articles->save();
    }

    function categoriesArticles($category, Article $article)
    {
        $this->authorize('view', $article);

        $articles = Article::latest()->where('category', $category)->paginate(6);
        $categories = Category::all();
        return view('articles.index', ['articles' => $articles, 'categories' => $categories]);
    }
    
    function edit(Article $article)
    {
        $this->authorize('update', $article);

        $categories = Category::all();
        return view('articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    function update(UpdateArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        if ($request->hasFile('image')) 
        {
            $fileName = time() . '.' . $request->image->extension();
            $file->move(public_path('/images/articles/' . $Articles->id), $fileName);
            $article->image = $fileName;
        }

        $article->title = $request->title;
        $article->description = $request->description;
        $article->content = $request->content;
        $article->category = $request->category;
        $article->published_at = $request->published_at;
        $article->update();

        return back()->with('message', 'Artikel succesvol bewerkt.');
    }
    
    function destroy(Request $request, Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();
        return back()->with('message', 'Artikel succesvol verwijderd.');
    }


    function adminIndex(Article $article)
    {
        $this->authorize('adminView', $article);

        $articles = Article::latest()->paginate(6);
        $categories = Category::all();
        // compact('variable', 'variable')
        return view('admin.articles.index', ['articles' => $articles, 'categories' => $categories]);
    }

    function adminCreate(Article $article)
    {
        $this->authorize('create', $article);

        $categories = Category::all();
        return view('admin.articles.create', ['categories' => $categories]);
    }

    function adminStore(StoreArticleRequest $request, Article $article)
    {
        $this->authorize('create', $article);

        $Articles = new Article;

        if ($request->hasFile('image')) 
        {
            $fileName = time() . '.' . $request->image->extension();
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
        if(isset($file))
        {
            $file->move(public_path('/images/articles/' . $Articles->id), $fileName);
        }
        return redirect('admin/articles')->with('message', 'Artikel succesvol gecreëerd.'); 
    }

    function adminCategoriesShow($category, Article $article)
    {
        $this->authorize('view', $article);

        $articles = Article::latest()->where('category', $category)->paginate(6);
        $categories = Category::all();
        return view('admin.articles.index', ['articles' => $articles, 'categories' => $categories, 'category' => $category]);
    }
    
    function adminEdit(Article $article)
    {
        $this->authorize('update', $article);

        $categories = Category::all();
        return view('admin.articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    function adminUpdate(UpdateArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        if ($request->hasFile('image')) 
        {
            $fileName = time() . '.' . $request->image->extension();
            $article->image = $fileName;
        }

        $article->title = $request->title;
        $article->description = $request->description;
        $article->content = $request->content;
        $article->category = $request->category;
        $article->published_at = $request->published_at;
        $article->update();
        if(isset($file))
        {
            $file->move(public_path('/images/articles/' . $Articles->id), $fileName);
        }

        return back()->with('message', 'Artikel succesvol bewerkt.');
    }
    
    function adminDestroy(Request $request, Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();
        return back()->with('message', 'Artikel succesvol verwijderd.');
    }
}
