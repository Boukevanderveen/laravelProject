<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoriesController extends Controller
{
    function index()
    {
        $categories = Category::latest()->paginate(6);

        return view('admin.categories.index', ['categories' => $categories]);
    }

    function createView()
    {
        return view('admin.categories.create');
    }

    function updateView($id, Category $category)
    {
        if (auth()->user()->can('update', $category)) {
        $category = Category::where('id', $id)->get();
        return view('admin.categories.update', ['category' => $category]);
        }
        else{
            return redirect('/admin/categories');
        }
    }

    function create(StoreCategoryRequest $request, Category $category)
    {
        $request->validated();

        if (auth()->user()->can('create', $category)) {

            $Categories = new Category;
            $Categories->name = $request->name;

            $Categories->save();

            return redirect('admin/categories')->with('message', 'Categorie succesvol gecreëerd.'); 
        }
        else
        {
            return redirect('admin/categories')->with('error', 'Geen rechten om een categorie te creëren. Contacteer een administrateur.');
        }
    }

    function update(Request $request, Category $category)
    {
        $request->validated();

        if (auth()->user()->can('update', $category)) 
        {
            $query = Category::where('id', $request->id)->update(['name' => $request->name]);
            if($query)
            {
                return redirect('/admin/categories')->with('message', 'Categorie succesvol bewerkt.');
            }
            else
            {
                return redirect('/admin/categories')->with('error', 'Er is een fout opgetreden met het bewerken van de categorie.');
        
            }
        }
        else
        {
            return redirect('/admin/categories')->with('error', 'Geen rechten om deze categorie te bewerken. Contacteer een administrateur.');
        }
    }

    function delete(Request $request, Category $category)
    {
        if (auth()->user()->can('delete', $category)) 
        {
            $query = Category::where('id', $request->id)->delete();
            if($query)
            {
                return redirect('/admin/categories')->with('message', 'Categorie succesvol verwijderd.');
            }
            else
            {
                return redirect('/admin/categories')->with('error', 'Er is een fout opgetreden met het verwijderen van de categorie.');

            }
        }
        else
        {
            return redirect('/admin/categories')->with('error', 'Geen rechten om deze categorie te verwijderen. Contacteer een administrateur.');
        }
    }
}
