<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use App\Models\Attribute;
use App\Models\AttributeType;
use App\Models\Product;
use Auth;

class TypesController extends Controller
{
    function index(Type $type)
    {
        $this->authorize('view', $type);

        $type = Type::latest()->paginate(6);

        return view('admin.types.index', ['types' => $type]);
    }

    function create(Type $type)
    {
        $this->authorize('create', $type);
        return view('admin.types.create', ['attributes' => Attribute::All()]);
    }

    function store(StoreTypeRequest $request, Type $type)
    {
        $Type = new Type;
        $Type->name = $request->name;
        $Type->save();
        $type = Type::find($Type->id);
        if(isset($request->all()["attributes"]))
        {
            foreach ($request->all()["attributes"] as $attribute) {
                if (!AttributeType::where('attribute_id', '=', $attribute)->where('type_id', '=', $type->id)->exists()) {
                $type->attributes()->attach($attribute);
                }
            }
        }
        else{
            AttributeType::where('type_id', '=', $type->id)->delete();
        }
        return redirect('admin/types')->with('message', 'Product type succesvol gecreëerd.'); 
    }

    function edit(Type $type)
    {
        $this->authorize('update', $type);
        $type = Type::where('id', $type->id)->first();
        return view('admin.types.edit', ['type' => $type, 'attributes' => Attribute::all()]);
    }

    function update(UpdateTypeRequest $request, Type $type)
    {
        $type->name = $request->name;
        $query = AttributeType::where('type_id', $type->id)->delete();
        if(isset($request->all()["attributes"]))
        {
            foreach ($request->all()["attributes"] as $attribute) {
                if (!AttributeType::where('attribute_id', '=', $attribute)->where('type_id', '=', $type->id)->exists()) {
                $type->attributes()->attach($attribute);
                }
            }
        }
        else{
            AttributeType::where('type_id', '=', $type->id)->delete();
        }
        $type->save();
        return redirect('/admin/types')->with('message', 'Product type succesvol bewerkt.');
    }

    function destroy(Type $type)
    {
        $this->authorize('delete', $type);
        AttributeType::where('type_id', $type->id)->delete();
        $linkedProducts = Product::where('type_id', $type->id)->get();
        foreach($linkedProducts as $product){
            $product->type_id == NULL;
        }
        $type->delete();  
        return back()->with('message', 'Product type succesvol verwijderd.');
        try {
            //ProductProductAttribute::where('product_id', $product->id)->delete();
           

          } catch (\Exception $e) {
            return back()->with('error', 'Product type kon niet worden verwijderd. Controleer of een product deze type nog gebruikt.');
        }
 
    }

    public function searchIndex(Request $request, Type $type)
    {
        $this->authorize('view', $type);

        $type = Type::where('name', 'like', '%' . $request->search_term.'%')
        ->latest()->paginate(6);

        return view('admin.types.index', ['types' => $type, 'search_term' => $request->search_term]);
    }
}
