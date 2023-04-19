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
    function adminIndex(Category $category)
    {
        $this->authorize('adminView', $category);

        $categories = Category::latest()->paginate(6);

        return view('admin.categories.index', ['categories' => $categories]);
    }

    function adminCreate(Category $category)
    {
        $this->authorize('create', $category);

        return view('admin.categories.create');
    }

    function adminStore(StoreCategoryRequest $request, Category $category)
    {
        $this->authorize('create', $category);
        $Categories = new Category;
        $Categories->name = $request->name;
        $Categories->save();
        return redirect('admin/categories')->with('message', 'Categorie succesvol gecreëerd.'); 
    }

    function adminEdit(Category $category)
    {
        $this->authorize('update', $category);
        $category = Category::where('id', $category->id)->get();
        return view('admin.categories.edit', ['category' => $category]);
    }

    function adminUpdate(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        $category->name = $request->name;
        $category->save();
        return redirect('/admin/categories')->with('message', 'Categorie succesvol bewerkt.');
    }

    function adminDestroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();  
        return back()->with('message', 'Categorie succesvol verwijderd.');
    }
}
