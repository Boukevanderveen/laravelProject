<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Type;
use App\Models\AttributeType;
use Auth;

class AttributesController extends Controller
{
    function index(Attribute $attribute)
    {
        $this->authorize('view', $attribute);

        $attributes = Attribute::latest()->paginate(6);

        return view('admin.attributes.index', ['attributes' => $attributes]);
    }

    function create(Attribute $attribute)
    {
        $this->authorize('create', $attribute);
        $types = Type::All();

        return view('admin.attributes.create', ['types' => $types]);
    }

    function store(StoreAttributeRequest $request, Attribute $attribute)
    {
        $Attribute = new Attribute;
        $Attribute->name = $request->name;
        $Attribute->save();
        return redirect('admin/attributes')->with('message', 'Attribuut succesvol gecreëerd.'); 
    }

    function edit(Attribute $attribute)
    {
        $this->authorize('update', $attribute);
        $attribute = Attribute::where('id', $attribute->id)->first();
        $types = Type::All();
        return view('admin.attributes.edit', ['attribute' => $attribute, 'types' => $types]);
    }

    function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $attribute->name = $request->name;
        $attribute->save();
        return redirect('/admin/attributes')->with('message', 'Attribuut succesvol bewerkt.');
    }

    function destroy(Attribute $attribute)
    {
            $this->authorize('delete', $attribute);
            AttributeType::where('attribute_id', $attribute->id)->delete();
            AttributeValue::where('attribute_id', $attribute->id)->delete();
            $attribute->delete();  
            return back()->with('message', 'Attribuut succesvol verwijderd.'); 
    }

    public function searchIndex(Request $request, Attribute $attribute)
    {
        $this->authorize('view', $attribute);

        $attributes = Attribute::where('name', 'like', '%' . $request->search_term.'%')
        ->latest()->paginate(6);

        return view('admin.attributes.index', ['attributes' => $attributes, 'search_term' => $request->search_term]);
    }
}
