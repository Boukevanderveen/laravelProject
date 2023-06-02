<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProductCategory;
use App\Models\ProductAttribute;
use App\Models\ProductProductAttribute;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Type;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreOrderDetailsRequest;
use App\Http\Requests\FilterProductPriceRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use Illuminate\Pagination\Paginator;
use Session;
use Auth;

class ProductsController extends Controller
{
    function index(Product $product, ProductCategory $category)
    {    
        $attributes = Attribute::All();
        $categories = ProductCategory::All();
        $types = Type::All();
        $products = Product::whereRelation('categories', 'product_category_id', $category->id)->get();
        $targetProductIds = array();
        foreach($products as $product){
            $targetProductIds[] = $product->id;
        }
        if((null !== session('selectedAttributeValues') && null !== session('priceFilter'))){
            $count = 0;
            foreach (session('selectedAttributeValues') as $attribute_id => $attributeValueIds){
                $count++;
                $targetProductIds = array();
                foreach($products as $product){
                    $targetProductIds[] = $product->id;
                }

                $targetAttributeIds = array();
                $targetAttributeValues = array();
                foreach ($attributeValueIds as $attributeValueId){
                    $valueName = AttributeValue::find($attributeValueId)->value;
                    $targetAttributeValues[] = $valueName;
                    $attributeId = AttributeValue::find($attributeValueId)->attribute_id;
                    $targetAttributeIds[] = $attributeId;
                }
                $query = Product::with('attributevalues');
                $attributeValueIdsLoopCount = 0;
                $filteredProductIds = array();
                foreach($attributeValueIds as $attributeValueId){
                    $attributeValueIdsLoopCount++;
                    $valueName = AttributeValue::find($attributeValueId)->value;
                    $attributeId = AttributeValue::find($attributeValueId)->attribute_id;
                    if($attributeValueIdsLoopCount == 1){
                        $query->whereHas('attributevalues', function($q) use ($valueName, $attributeId, $targetProductIds){
                            $q->where('value', $valueName);
                            $q->where('attribute_id', $attributeId);
                        });
                    }
                    else{
                        $query->orWhereHas('attributevalues', function($q) use ($valueName, $attributeId, $targetProductIds){
                            $q->where('value', $valueName);
                            $q->where('attribute_id', $attributeId);
                        });
                    }
                    $filteredProducts = $query->get();
                    foreach($filteredProducts as $filteredProduct){
                        $filteredProductIds[] = $filteredProduct->id;
                    }
                }
                $products = Product::whereIn('id', $targetProductIds)->whereIn('id', $filteredProductIds)->get();
            }
            $targetProductIds = array();
            foreach($products as $product){
                $targetProductIds[] = $product->id;
            }
            if(session('priceFilter')['max_price'] == ""){
                $max_price = 999999;
            }
            else{
                $max_price = session('priceFilter')['max_price'];
            }
            $min_price = session('priceFilter')['min_price'];
            $productsWithPrice = Product::whereIn('id', $targetProductIds)->whereNull('discount_price')
            ->whereBetween('price', [$min_price, $max_price])->get();
            $productsWithDiscountPrice = Product::whereIn('id', $targetProductIds)->whereNotNull('discount_price')
            ->whereBetween('discount_price', [$min_price, $max_price])->get();
            $products = $productsWithPrice->merge($productsWithDiscountPrice);
            $products = $products->sortByDesc('created_at')->paginate(12);
            return view('products.index', ['products' => $products, 'selectedAttributeValues' => session('selectedAttributeValues'), 'category' => $category, 'attributes' => $attributes, 'minPrice' => session('priceFilter')['min_price'], 'maxPrice' => session('priceFilter')['max_price']]);
        }
        
        if((null !== session('selectedAttributeValues'))){
            
            $count = 0;
            foreach (session('selectedAttributeValues') as $attribute_id => $attributeValueIds){
                $count++;
                $targetProductIds = array();
                foreach($products as $product){
                    $targetProductIds[] = $product->id;
                }

                $targetAttributeIds = array();
                $targetAttributeValues = array();
                foreach ($attributeValueIds as $attributeValueId){
                    $valueName = AttributeValue::find($attributeValueId)->value;
                    $targetAttributeValues[] = $valueName;
                    $attributeId = AttributeValue::find($attributeValueId)->attribute_id;
                    $targetAttributeIds[] = $attributeId;
                }
                $query = Product::with('attributevalues');
                $attributeValueIdsLoopCount = 0;
                $filteredProductIds = array();
                foreach($attributeValueIds as $attributeValueId){
                    $attributeValueIdsLoopCount++;
                    $valueName = AttributeValue::find($attributeValueId)->value;
                    $attributeId = AttributeValue::find($attributeValueId)->attribute_id;
                    if($attributeValueIdsLoopCount == 1){
                        $query->whereHas('attributevalues', function($q) use ($valueName, $attributeId, $targetProductIds){
                            $q->where('value', $valueName);
                            $q->where('attribute_id', $attributeId);
                        });
                    }
                    else{
                        $query->orWhereHas('attributevalues', function($q) use ($valueName, $attributeId, $targetProductIds){
                            $q->where('value', $valueName);
                            $q->where('attribute_id', $attributeId);
                        });
                    }
                    $filteredProducts = $query->get();
                    foreach($filteredProducts as $filteredProduct){
                        $filteredProductIds[] = $filteredProduct->id;
                    }
                }
                $products = Product::whereIn('id', $targetProductIds)->whereIn('id', $filteredProductIds)->get();
            }
            $products = $products->sortByDesc('created_at')->paginate(12);
            return view('products.index', ['types' => $types, 'products' => $products, 'category' => $category, 'selectedAttributeValues' => session('selectedAttributeValues'), 'attributes' => $attributes]);
        }
        
        if((null !== session('priceFilter'))){
            if(session('priceFilter')['max_price'] == ""){
                $max_price = 999999;
            }
            else{
                $max_price = session('priceFilter')['max_price'];
            }
            $min_price = session('priceFilter')['min_price'];
            $productsWithPrice = Product::whereIn('id', $targetProductIds)->whereNull('discount_price')
            ->whereBetween('price', [$min_price, $max_price])->get();
            $productsWithDiscountPrice = Product::whereIn('id', $targetProductIds)->whereNotNull('discount_price')
            ->whereBetween('discount_price', [$min_price, $max_price])->get();
            $products = $productsWithPrice->merge($productsWithDiscountPrice);
            $products = $products->sortByDesc('created_at')->paginate(12);
            return view('products.index', ['types' => $types, 'products' => $products,  'category' => $category, 'minPrice' => session('priceFilter')['min_price'], 'maxPrice' => session('priceFilter')['max_price'], 'attributes' => $attributes]);
        }

        $products = Product::whereRelation('categories', 'product_category_id', $category->id)->latest()->paginate(12);
        return view('products.index', ['types' => $types, 'products' => $products, 'category' => $category, 'attributes' => $attributes]);
    }

    function indexAttributes(Request $request)
    {
        $selectedAttributeValues = $request->all();
        unset($selectedAttributeValues['_token']);
        if(null == $selectedAttributeValues){
            Session::forget('selectedAttributeValues');
            return back(); 
        }
        $values = array();
        foreach($selectedAttributeValues as $key => $value)
        {
            $attribute_id = strtok($value, ',');
            $value_id = substr($value, strpos($value, ",") + 1);  
            $values[$attribute_id][] = $value_id;
        }    
        session()->put('selectedAttributeValues', $values);
        return back();
    }
  
    function indexPrice(FilterProductPriceRequest $request, Product $product, ProductCategory $category)
    {
        if(null == $request->max_price && null == $request->min_price){
            Session::forget('priceFilter');
            return back(); 
        }
        $priceFilter["min_price"] = str_replace(',', '.', $request->min_price);
        $priceFilter["max_price"] = str_replace(',', '.', $request->max_price);
        session()->put('priceFilter', $priceFilter);
        return back();
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

    function attributesEdit(Product $product)
    {
        $this->authorize('update', $product);
        $product = Product::find($product->id);
        //dd($product->type-)
        return view('admin.products.attributes', ['product' => $product]);
    }

    function attributesUpdate(UpdateAttributeValueRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        foreach ($request->attributeValues as $key => $value) {
            if($key !== "_token" && $key !== "attributeValues" && null !== $value)
            {
                AttributeValue::where('attribute_id', $key)->where('product_id', $product->id)->delete();
                $AttributeValue = new AttributeValue;
                $AttributeValue->value = $value;
                $AttributeValue->attribute_id = $key;
                $AttributeValue->product_id = $product->id;
                $AttributeValue->save();
            }
            if($key !== "_token" && $key !== "attributeValues" && null == $value){
                AttributeValue::where('attribute_id', $key)->where('product_id', $product->id)->delete();
                Session::forget('selectedAttributeValues');
            }
        }
        return back()->with('message', 'Product attributen succesvol bewerkt');
    }

    function create(Product $product)
    {
        $this->authorize('create', $product);
        $categories = ProductCategory::all();
        $types = Type::all();

        return view('admin.products.create', ['categories' => $categories, 'types' => $types]);
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
        if(isset($product->type->id)){
        if(!$product->type->id == $request->typeid){
            AttributeValue::where('product_id', $product->id)->delete();
        }
        }
        $Product->type()->associate($request->typeid);
        $Product->stock = $request->stock;
        $Product->vat = sprintf("%.2f", $request->vat);
        $Product->description = $request->description;
        $Product->save();
        if(isset($file)){
            $file->move(public_path('/images/products/' . $Product->id), $fileName);
        }
        if($request->filled('categories')){
            foreach ($request->categories as $category) {
                $Product->categories()->attach($category);
            }
        }
        if($request->filled('attributes')){
            foreach ($request->all()["attributes"] as $attribute) {
                $Product->attributes()->attach($attribute);
            }
        }
        return redirect('admin/products')->with('message', 'Product succesvol gecreëerd.'); 
    }

    function edit(Product $product)
    {
        $this->authorize('update', $product);
        //$product = Product::where('id', $product->id)->first();
        $types = Type::all();
        $categories = ProductCategory::all();
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories, 'types' => $types]);
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
        if(isset($product->type->id) && (int)$request->typeid !== $product->type->id)
        {
            $query = AttributeValue::where('product_id', $product->id)->delete();
            Session::forget('selectedAttributeValues');
        }
        
        $product->type()->associate($request->typeid);
        $product->stock = $request->stock;
        $product->vat = sprintf("%.2f", $request->vat);
        $product->description = $request->description;
        
        $query = ProductProductCategory::where('product_id',$product->id)->delete();
        $product->update();

        if($request->filled('categories')){
        foreach ($request->categories as $category) {
                if (!ProductProductCategory::where('product_id', '=', $product->id)->where('product_category_id', '=', $category)->exists()) {                    
                //$product->categories()->attach($category);

                $ProductProductCategory = new ProductProductCategory;
                $ProductProductCategory->product_id = $product->id;
                $ProductProductCategory->product_category_id = $category;
                $ProductProductCategory->save();
            }
        }
        }
        else
        {
            $product->categories()->update(['product_id' => null]);
        }

        return back()->with('message', 'Product succesvol bewerkt.');
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
            AttributeValue::where('product_id', $product->id)->delete();
            Session::forget('selectedAttributeValues');
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

