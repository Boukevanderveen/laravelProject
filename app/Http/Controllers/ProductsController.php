<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProductCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreOrderDetailsRequest;
use Session;
use Auth;

class ProductsController extends Controller
{
    function index(Product $product)
    {

        $products = Product::latest()->paginate(6);

        return view('products.index', ['products' => $products]);
    }

    function show(Product $product)
    {

        $cart = session()->get('cart', []);
        if(isset($cart[$product->id]['quantity'])){
            $itemsInCart = $cart[$product->id]['quantity'];
        }
        else{
            $itemsInCart = 0;
        }
        return view('products.show', ['product' => $product, 'itemsInCart' => $itemsInCart]);
    }

    function adminIndex(Product $product)
    {
        $this->authorize('view', $product);

        $products = Product::latest()->paginate(6);

        return view('admin.products.index', ['products' => $products]);
    }

    function create(Product $product)
    {
        $this->authorize('create', $product);
        $categories = ProductCategory::all();

        return view('admin.products.create', ['categories' => $categories]);
    }

    function store(StoreProductRequest $request, Product $product)
    {   

        $Product = new Product;

        $Product->name = $request->name;
        if ($request->hasFile('picture')) 
        {
            $fileName = time() . '.' . $request->picture->extension();
            $file = $request->file('picture');
            $Product->picture = $fileName;
        }
        $Product->price = str_replace(',', '.', $request->price);
        if (isset($request->discount_price)) 
        {
            $Product->discount_price = str_replace(',', '.', $request->discount_price);
        }
        $Product->stock = $request->stock;
        $Product->vat = sprintf("%.2f", $request->vat);
        $Product->description = $request->description;
        $Product->save();
        if(isset($file)){
            $file->move(public_path('/images/products/' . $Product->id), $fileName);

        }
        
        if(isset($request->categories)){
            foreach ($request->categories as $category) {
                $Product->categories()->attach($category);
            }
        }

        return redirect('admin/products')->with('message', 'Product succesvol gecreëerd.'); 
    }

    function edit(Product $product)
    {
        $this->authorize('update', $product);
        //$product = Product::where('id', $product->id)->first();
        $categories = ProductCategory::all();
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    function update(UpdateProductRequest $request, Product $product)
    {
        
        $product->name = $request->name;
        if ($request->hasFile('picture')) 
        {
            $fileName = time() . '.' . $request->picture->extension();
            $file = $request->file('picture');
            $product->picture = $fileName;
            $file->move(public_path('/images/products/' . $product->id), $fileName);
        }
        $product->price = str_replace(',', '.', $request->price);
        if ($request->filled('discount_price')) 
        {
            $product->discount_price = str_replace(',', '.', $request->discount_price);
        }
        else
        {
            $product->discount_price = NULL;
        }
        $product->stock = $request->stock;
        $product->vat = sprintf("%.2f", $request->vat);
        $product->description = $request->description;
        
        $query = ProductProductCategory::where('product_id',$product->id)->delete();

        if(isset($request->categories)){
        foreach ($request->categories as $category) {
            $product->categories()->attach($category);
        }
        }
        else
        {
            $product->categories()->update(['product_id' => null]);
        }

        $product->update();
        return redirect('/admin/products')->with('message', 'Product succesvol bewerkt.');
    }

    function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if (OrderDetail::where('product_id', '=', $product->id)->exists()) {
            return back()->with('error', 'Product kon niet worden verwijderd. Dit product zit al in een bestelling.');
        }
        else{
            $this->authorize('delete', $product);
            ProductProductCategory::where('product_id', $product->id)->delete();
            $product->delete();  
            return back()->with('message', 'Product succesvol verwijderd.');
        }
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('products.cart');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart(Request $request)
    {

        $product = Product::find($request->productid);
          
        $cart = session()->get('cart', []);

        if(isset($request->quantity) && !isset($cart[$request->productid])){

                $cart[$request->productid] = [
                    "id" => $product->id,
                    "name" => $product->name,
                    "quantity" => $request->quantity,
                    "price" => $product->price,
                    "discount_price" => $product->discount_price,
                    "picture" => $product->picture,
                    "vat" => $product->vat,
                    "stock" => $product->stock,
                ];
                session()->put('cart', $cart);
                return back()->with('message', 'Artikel(en) succesvol toegevoegd aan de winkelwagen');

            }
        
        else if(isset($cart[$request->productid])) {
            if(isset($request->quantity)) {

                $cart[$request->productid]['quantity'] = $request->quantity;

                session()->put('cart', $cart);
                return back()->with('message', 'Artikel(en) succesvol toegevoegd aan de winkelwagen');
            }
            else{
                $cart[$request->productid]['quantity']++;

            }

        } else {
            
        $cart[$product->id] = [
            "id" => $product->id,
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "discount_price" => $product->discount_price,
            "picture" => $product->picture,
            "picture" => $product->picture,
            "vat" => $product->vat,
            "stock" => $product->stock,
        ];

        }
        session()->put('cart', $cart);
        return back()->with('message', 'Artikel succesvol toegevoegd aan de winkelwagen');
    }

        /**
     * Write code on Method
     *
     * @return response()
     */
    public function updateCard(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('message', 'Winkelwagen succesvol bewerkt');
        }
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return back()->with('message', 'Artikel succesvol verwijderd');
        }
    }

        /**
     * Write code on Method
     *
     * @return response()
     */
    public function searchIndex(Product $product, Request $request)
    {
        $this->authorize('view', $product);

        $products = Product::where('name', 'like', '%' . $request->search_term.'%')
        ->latest()->paginate(6);

        return view('admin.products.index', ['products' => $products, 'search_term' => $request->search_term]);
    }
}

