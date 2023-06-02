@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">

            <h1>Factuuradres</h1>
        </div>
    </div>
    @php 
    $total = 0;
    $total_vat = 0;
    @endphp
    @foreach(session('cart') as $id => $details)
        @if(isset($details['discount_price']))
        @php $total += $details['discount_price'] * $details['quantity'];
        $total_vat += $details['discount_price'] * $details['quantity'] * $details['vat']/100 + ($details['discount_price'] * $details['quantity']) @endphp
        @else
        @php $total += $details['price'] * $details['quantity'];
        $total_vat +=  $details['price'] * $details['quantity'] * $details['vat']/100 + ($details['price'] * $details['quantity']) @endphp
        @endif
    @endforeach
    <div class="row">
        <div class="col-8">
            <form class="card"method="post" name="productform" action="{{ route('orders.store') }}">
                <div class="row mb-3 mt-5">
                    <label for="flexCheckDefault" class="col-md-7 col-form-label text-md-end">Zelfde als afleveradres:</label>
                    <div class="col-md-5">
                        <input class="form-check-input mt-2" type="checkbox" value="" id="myCheckbox">
                    </div>
                </div>
            <input value="invoiceadress" type="hidden" name="type">
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                            value="{{ old('name') }}" type="text" name="name" autofocus>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="company_name" class="col-md-4 col-form-label text-md-end">Bedrijfsnaam:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('company_name') is-invalid @enderror" id="company_name"
                            value="{{ old('company_name') }}" type="text" name="company_name" autofocus>
                        @if ($errors->has('company_name'))
                            <div class="invalid-feedback">{{ $errors->first('company_name') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="street" class="col-md-4 col-form-label text-md-end">Straatnaam:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}"
                            type="text" id="street" name="street" autofocus>
                        @if ($errors->has('street'))
                            <div class="invalid-feedback">{{ $errors->first('street') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="house_number" class="col-md-4 col-form-label text-md-end">Huisnummer:</label>
                    <div class="col-md-2">
                        <input class="form-control @error('house_number') is-invalid @enderror" value="{{ old('house_number') }}" type="text" id="house_number" name="house_number"autofocus>
                        @if ($errors->has('house_number'))
                            <div class="invalid-feedback">{{ $errors->first('house_number') }}</div>
                        @endif
                    </div>
                    <label for="addition" class="col-md-2 col-form-label text-md-end">Toevoeging:</label>
                    <div class="col-md-1">
                        <input class="form-control @error('addition') is-invalid @enderror" value="{{ old('addition') }}"
                            type="text" id="addition"name="addition" autofocus>
                        @if ($errors->has('addition'))
                            <div class="invalid-feedback">{{ $errors->first('addition') }}</div>
                        @endif
                    </div>

                </div>

                <div class="row mb-3">
                    <label for="zipcode" class="col-md-4 col-form-label text-md-end">Postcode:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('zipcode') is-invalid @enderror" id="zipcode"
                            value="{{ old('zipcode') }}" type="text" name="zipcode" autofocus>
                        @if ($errors->has('zipcode'))
                            <div class="invalid-feedback">{{ $errors->first('zipcode') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="city" class="col-md-4 col-form-label text-md-end">Woonplaats:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('city') is-invalid @enderror" id="city"
                            value="{{ old('city') }}" type="text" name="city" autofocus>
                        @if ($errors->has('city'))
                            <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone_number" class="col-md-4 col-form-label text-md-end">Telefoon:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}"
                            type="text" id="phone_number" name="phone_number" autofocus>
                        @if ($errors->has('phone_number'))
                            <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">E-mail:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            type="text" id="email" name="email" autofocus>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-8">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#adressBookModal" class="btn mb-3">Kies adres uit adresboek</button>
                        <a href="{{ route('products.cart') }}"><button type="button" class="btn mb-3">Ga
                                terug</button></a>
                        <button type="submit" class="btn btn-primary mb-3">Bevestig</button>
                    </div>
                </div>
                <input name="total" type="hidden" value="{{ $total }}">
                <input name="total_vat" type="hidden" value="{{ $total_vat }}">
                <input name="shipmentAdressRequest" type="hidden" value="{{ json_encode(session('orderadres')[0]) }}">
                @csrf
            </form>
        </div>
        <div class="col-4">
            <div class="row m-1">
                <h5>Samenvatting:</h5>
                <ul class="list-group card">
                    <div class="row">
                        <div class="col-8">
                            <li class="list-group-item border-0">Subtotaal:</li>
                            <li class="list-group-item border-0">Btw:</li>
                            <li class="list-group-item border-0">Totaal excl. btw:</li>
                            <li class="list-group-item border-0">Totaal incl. btw:</li>
                        </div>
                        <div class="col-4 text-end">
                            <li class="list-group-item border-0">€ {{ str_replace('.', ',', number_format((float)$total, 2, '.', '')) }}</li>
                            <li class="list-group-item border-0">€ {{ str_replace('.', ',', number_format((float)$total_vat - $total, 2, '.', '')) }}</li>
                            <li class="list-group-item border-0">€ {{ str_replace('.', ',', number_format((float)$total, 2, '.', '')) }}</li>
                            <li class="list-group-item border-0">€ {{ str_replace('.', ',', number_format((float)$total_vat, 2, '.', '')) }}</li>
                        </div>
                    </div>
                </ul>
            </div>
            <div class="row m-1" id="deliveryAdressRow">
                <h5>Afleveradres:</h5>
                    @php $shipmentAdress = session('orderadres')[0]; @endphp
                <ul class="list-group card">
                    <div class="row">
                        <div class="col-6">

                            <li class="list-group-item border-0">Naam:</li>
                            <li class="list-group-item border-0">Bedrijfsnaam:</li>
                            <li class="list-group-item border-0">Straat:</li>
                            <li class="list-group-item border-0">Huisnummer:</li>
                            <li class="list-group-item border-0">Postcode:</li>
                            <li class="list-group-item border-0">Telefoonnummer:</li>
                            <li class="list-group-item border-0">E-mail:</li>
                        </div>
                        <div class="col-6 text-end">
                            <li class="list-group-item border-0"> {{$shipmentAdress['name']}} </li>
                            <li class="list-group-item border-0"> {{$shipmentAdress['company_name']}} </li>
                            <li class="list-group-item border-0"> {{$shipmentAdress['street']}} </li>
                            <li class="list-group-item border-0"> {{$shipmentAdress['house_number']}} {{$shipmentAdress['addition']}} </li>
                            <li class="list-group-item border-0"> {{$shipmentAdress['zipcode']}} </li>
                            <li class="list-group-item border-0"> {{$shipmentAdress['phone_number']}} </li>
                            <li class="list-group-item border-0"> {{$shipmentAdress['email']}} </li>
                        </div>
                    </div>
                </ul>

            </div>
            <div class="row m-1">
                <h5>Winkelmandje:</h5>
                <div class="card">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Artikel</th>
                            <th>Aantal</th>
                            <th></th>
                        </tr>
                    </thead>
                        @php 
                        $total = 0;
                        $total_vat = 0;
                        @endphp
                        <tbody>
                            @foreach(session('cart') as $id => $details)
                                @if(isset($details['discount_price']))
                                @php $total += $details['discount_price'] * $details['quantity'];
                                $total_vat += $details['discount_price'] * $details['quantity'] * $details['vat']/100 + ($details['discount_price'] * $details['quantity']) @endphp
                                @else
                                @php $total += $details['price'] * $details['quantity'];
                                $total_vat +=  $details['price'] * $details['quantity'] * $details['vat']/100 + ($details['price'] * $details['quantity']) @endphp
                                @endif
                                <tr data-id="{{ $id }}">
                                    <td >
                                        <div class="row">
                                            @if($details['picture']) 
                                            <div class="col-sm-5 hidden-xs"><img src="{{ asset('images/products/'.$details['id'].'/'.$details['picture'].'') }}" width="80" height="80" class="img-fluid"/></div>
                                            @else
                                            <div class="col-sm-5 hidden-xs"><img src="{{ asset('images/default-image.png') }}" width="80" height="80" class="img-fluid"/></div>
                                            @endif
                                            <div class="col-sm-7">
                                                <h5 class="nomargin">{{ $details['name'] }}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{str_replace('.', ',', $details['quantity']) }}</td>
        
                                    @if(isset($details['discount_price']))
                
                                    @else
                                    @endif
                                    <td class="actions" data-th="">
                                    </td>
                                </tr>
                            @endforeach   
                    </tbody>
                </table>
            </div>
            </div>
            
        </div>
    </div>
    <script>
    document.getElementById("myCheckbox").click();
    var target = <?php Print(json_encode(session('orderadres')[0])); ?>;
        for (let k in target){
            if (target.hasOwnProperty(k)) {
                var elementExists = document.getElementById(k);
                if (elementExists != null) {
                var s = document.getElementById(k);
                s.value = target[k];
            }

            }
        }

        const checkbox = document.getElementById('myCheckbox')
        checkbox.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            var target = <?php Print(json_encode(session('orderadres')[0])); ?>;
        for (let k in target){
            if (target.hasOwnProperty(k)) {
                var elementExists = document.getElementById(k);
                if (elementExists != null) {
                var s = document.getElementById(k);
                s.value = target[k];
            }

            }
        }
        
        } else {
            var target = <?php Print(json_encode(session('orderadres')[0])); ?>;
        for (let k in target){
            if (target.hasOwnProperty(k)) {
                var elementExists = document.getElementById(k);
                if (elementExists != null) {
                var s = document.getElementById(k);
                s.value = "";
            }
            }
        }
        }
        })
    </script>
@endsection
<div class="modal fade modal-lg" id="adressBookModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="row">
        <div class="col-8">
          <h4 class="modal-title m-2">Adresboek</h4>
        </div>
        <div class="col-4 text-end">
            <a href="{{ route('adresses.create') }}"><button class="btn btn-primary m-1">Nieuw adres</button></a>
            <button type="button" id="modal-close" class="btn-close m-2" data-bs-dismiss="modal"></button>          
        </div>
          
        </div>
<div class="row">   
        <div class="modal-body">
                <div class="row mb-3 mt-3">
                    <div class="col-md">
                        
                        @foreach($adresses as $adress)
                        @php $array = json_encode($adress) @endphp
                        <div 
                                role="button" role="button"class="card mt-2" onclick="
                                var target = {{$array}}
                        for (let k in target){
                            if (target.hasOwnProperty(k)) {
                                var elementExists = document.getElementById(k);
                                if (elementExists != null) {
                                var s = document.getElementById(k);
                                s.value = target[k];
                                document.getElementById('modal-close').click();
                                
                            }
                
                            }
                        }
                                ">
                                        <div class="m-2"> 
                                            <h6>{{$adress->name}}</h6>
                                            <h6>{{$adress->street}} {{$adress->house_number}}{{$adress->addition}}</h6>
                                            <h6>{{$adress->zipcode}} {{$adress->city}}</h6>
                                        </div>
                        </div>
                        @endforeach
                    </div>
                </div>
        </div>
      </div>
    </div>
</div>
</div>