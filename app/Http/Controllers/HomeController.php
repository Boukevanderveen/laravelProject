<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Project;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.home', ['dataDisplay' => 'none']);
    }
    
    public function indexArticles()
    {
        $articles = Article::All();

        return view('home.home', ['articles' => $articles, 'dataDisplay' => 'articles']);
    }

    public function indexProjects()
    {
        $projects = Project::All();

        return view('home.home', ['projects' => $projects, 'dataDisplay' => 'projects']);
    }

    public function indexUsers(User $user)
    {
        if (auth()->user()->can('update', $user)) 
        {
            $users = User::All();

            return view('home.home', ['users' => $users, 'dataDisplay' => 'users']);
        }
        else
        {           
            return redirect('');
        }
    }
}
