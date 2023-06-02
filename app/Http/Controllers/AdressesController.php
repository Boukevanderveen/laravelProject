<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adress;
use App\Models\User;
use App\Http\Requests\StoreAdressRequest;
use App\Http\Requests\UpdateAdressRequest;
use Auth;

class AdressesController extends Controller
{
    function index(Adress $adress)
    {
        $this->authorize('view', $adress);

        $adresses = Adress::where('user_id', Auth::user()->id)->latest()->paginate();
        return view('adresses.index', ['adresses' => $adresses]);
    }

    function show(Adress $adress)
    {
        $this->authorize('viewAny', $adress);

        return view('orders.show', ['adress' => $adress]);
    }

    function create(Adress $adress)
    {
        $this->authorize('create', $adress);
        return view('adresses.create');
    }

    function store(StoreAdressRequest $request)
    {
        $Adress = new Adress;
        $Adress->name = $request->name;
        $Adress->company_name = $request->company_name;
        $Adress->street = $request->street;
        $Adress->phone_number = $request->phone_number;
        $Adress->house_number = $request->house_number;
        $Adress->addition = $request->addition;
        $Adress->zipcode = $request->zipcode;
        $Adress->city = $request->city;
        $Adress->email = $request->email;
        $Adress->user_id = Auth::user()->id;
        $Adress->save();
        return redirect('adresses')->with('message', 'Adres succesvol aangemaakt.');
    }

    function edit(Adress $adress)
    {
        $this->authorize('update', $adress);
        return view('adresses.edit', ['adress' => $adress]);   
    }

    function update(UpdateAdressRequest $request, Adress $adress)
    {
        $adress->name = $request->name;
        $adress->company_name = $request->company_name;
        $adress->street = $request->street;
        $adress->phone_number = $request->phone_number;
        $adress->house_number = $request->house_number;
        $adress->addition = $request->addition;
        $adress->zipcode = $request->zipcode;
        $adress->city = $request->city;
        $adress->email = $request->email;
        $adress->user_id = Auth::user()->id;
        $adress->update();
        return redirect('adresses')->with('message', 'Adres succesvol bewerkt.');
    }

    function destroy(Adress $adress)
    {
        $this->authorize('delete', $adress);

        $adress->delete();
        return back()->with('message', 'Adres succesvol verwijderd.');
    }

    function adminIndex(Adress $adress)
    {
        $this->authorize('view', $adress);

        $adresses = Adress::latest()->paginate(6);
        return view('admin.adresses.index', ['adresses' => $adresses]);
    }

    function adminCreate(Adress $adress)
    {
        $this->authorize('create', $adress);
        $users = User::All();
        return view('admin.adresses.create',['users' => $users]);
    }

    function adminStore(StoreAdressRequest $request)
    {
        $user = User::where('name', 'like', '%' . $request->user)->first();
        if(isset($user)){
            $Adress = new Adress;
            $Adress->name = $request->name;
            $Adress->company_name = $request->company_name;
            $Adress->street = $request->street;
            $Adress->phone_number = $request->phone_number;
            $Adress->house_number = $request->house_number;
            $Adress->addition = $request->addition;
            $Adress->zipcode = $request->zipcode;
            $Adress->city = $request->city;
            $Adress->email = $request->email;
            $Adress->user_id = $user->id;
            $Adress->save(); 
            return redirect('admin/adresses')->with('message', 'Adres succesvol aangemaakt.');
        }
        else{
        return back()->with('error', 'Deze gebruiker bestaat niet. Controleer mogelijke typfouten.');
        }
    }

    function adminEdit(Adress $adress)
    {
        $this->authorize('update', $adress);
        return view('admin.adresses.edit', ['adress' => $adress]);   
    }

    function adminUpdate(UpdateAdressRequest $request, Adress $adress)
    {
        $adress->name = $request->name;
        $adress->company_name = $request->company_name;
        $adress->street = $request->street;
        $adress->phone_number = $request->phone_number;
        $adress->house_number = $request->house_number;
        $adress->addition = $request->addition;
        $adress->zipcode = $request->zipcode;
        $adress->city = $request->city;
        $adress->email = $request->email;
        $adress->user_id = Auth::user()->id;
        $adress->update();
        return redirect('admin/adresses')->with('message', 'Adres succesvol bewerkt.');
    }

    function adminDestroy(Adress $adress)
    {
        $this->authorize('delete', $adress);

        $adress->delete();
        return back()->with('message', 'Adres succesvol verwijderd.');
    }

    function searchIndex(Request $request, Adress $adress)
    {
        $this->authorize('view', $adress);
        $user = User::where('name', 'like', '%' . $request->search_term)->first();
        if(isset($user)){
            $adresses = Adress::where('user_id', $user->id)
            ->latest()->paginate(6);
            return view('admin.adresses.index', ['adresses' => $adresses, 'search_term' => $request->search_term]);
        }
        $adresses = Adress::where('user_id', -1)->paginate();
        return view('admin.adresses.index', ['adresses' => $adresses, 'search_term' => $request->search_term]);
    }
}
