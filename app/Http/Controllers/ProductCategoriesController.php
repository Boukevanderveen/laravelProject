<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;

class ProductCategoriesController extends Controller
{
    function index(ProductCategory $category)
    {
        $this->authorize('view', $category);

        $categories = ProductCategory::latest()->paginate(6);

        return view('admin.productcategories.index', ['categories' => $categories]);
    }

    function create(ProductCategory $category)
    {
        $this->authorize('create', $category);

        return view('admin.productcategories.create');
    }

    function store(StoreProductCategoryRequest $request, ProductCategory $category)
    {
        $Category = new ProductCategory;
        $Category->name = $request->name;
        $Category->save();
        return redirect('admin/productcategories')->with('message', 'Categorie succesvol gecreëerd.'); 
    }

    function edit(ProductCategory $category)
    {
        $this->authorize('update', $category);
        $category = ProductCategory::where('id', $category->id)->first();
        return view('admin.productcategories.edit', ['category' => $category]);
    }

    function update(UpdateProductCategoryRequest $request, ProductCategory $category)
    {
        $category->name = $request->name;
        $category->save();
        return redirect('/admin/productcategories')->with('message', 'Categorie succesvol bewerkt.');
    }

    function destroy(ProductCategory $category)
    {
        try {
            $this->authorize('delete', $category);
            $category->delete();  
            return back()->with('message', 'Product categorie succesvol verwijderd.');

          } catch (\Exception $e) {
            return back()->with('error', 'Product categorie kon niet worden verwijderd. Controleer of een product deze categorie nog gebruikt.');
        }
 
    }

    public function searchIndex(ProductCategory $category, Request $request)
    {
        $this->authorize('view', $category);

        $categories = ProductCategory::where('name', 'like', '%' . $request->search_term.'%')
        ->latest()->paginate(6);

        return view('admin.productcategories.index', ['categories' => $categories, 'search_term' => $request->search_term]);
    }
}
