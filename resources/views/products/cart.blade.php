@extends('layouts.app')
  
@section('content')
@if(session('cart'))
<div class="row">
<div class="col-12">
<h1>Winkelmandje</h1>
</div>
</div>
<div class="row">
<div class="col-9">
<div class="card">
<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th>Artikel</th>
            <th>Prijs</th>
            <th>Aantal</th>
            <th>Btw</th>
            <th>Totaal (excl. btw)</th>
            <th>Totaal (incl. btw)</th>
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
                    @if(isset($details['discount_price']))
                    <td>€ {{str_replace('.', ',', $details['discount_price']) }}</td>
                    @else
                    <td>€ {{str_replace('.', ',', $details['price']) }}</td>
                    @endif

                    <td>
                        <div class="col">
                            <form action="{{ route('products.add.to.cart') }}" method="POST">
                                @csrf
                                <select onchange="this.form.submit()" class="form-select @error('category') is-invalid @enderror" name="quantity" id="quantity" aria-label="Default select example">                                    
                                    <option value="{{$details['quantity']}}" selected>{{$details['quantity']}}</option>
                                    @for ($i = 1; $i < $details['stock']+1 && $i < 100; $i++ )
                                    
                                    @if($i != $details['quantity'])
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endif
                                    @endfor
                                    <input name="productid" type="hidden" value="{{$details['id']}}">
                                    <input type="submit" hidden />
                                </select>
                            </form>
                        </div>
                    </td>
                    
                    <td class="text-center">{{ str_replace('.', ',', number_format($details['vat']))}}%</td>


                    @if(isset($details['discount_price']))
                    <td class="text-center">€ {{ str_replace('.', ',', number_format($details['discount_price'] * $details['quantity'] , 2))}}</td>
                    <td class="text-center">€ {{ str_replace('.', ',', number_format($details['discount_price'] * $details['quantity'] * $details['vat']/100 + $details['discount_price'] * $details['quantity'], 2))}}</td>

                    @else
                    <td class="text-center">€ {{str_replace('.', ',', number_format($details['price'] * $details['quantity'] , 2))}}</td>
                    <td class="text-center">€ {{ str_replace('.', ',', number_format($details['price'] * $details['quantity'] * $details['vat']/100 + $details['price'] * $details['quantity'], 2))}}</td>
                    @endif
                    <td class="actions" data-th="">
                        <form action="{{ route('products.remove.from.cart', $details) }}" method="POST">
                            <input mame="id" type="hidden" value="{{$details['id']}}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-link link-dark"><i
                                    class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach   
    </tbody>
</table>
</div>
</div>
<div class="col-3">
    <ul class="list-group border">
            <li class="list-group-item border-0"><h5>Samenvatting:</h5></li>
            <li class="list-group-item border-0">Subtotaal: € {{ str_replace('.', ',', number_format((float)$total, 2, '.', '')) }}</li>
            <li class="list-group-item border-0">Btw: € {{ str_replace('.', ',', number_format((float)$total_vat - $total, 2, '.', '')) }}</li>
            <li class="list-group-item border-0"></li>
            <li class="list-group-item border-0">Totaal excl. btw: € {{ str_replace('.', ',', number_format((float)$total, 2, '.', '')) }}</li>
            <li class="list-group-item border-0">Totaal incl. btw: € {{ str_replace('.', ',', number_format((float)$total_vat, 2, '.', '')) }}</li>
    </ul>
    @guest
    <p> Log in om naar de kassa te gaan</p>
    <a href="{{ route('products.index') }}"><button type="button" class="btn ">Ga terug</button></a>
    <a href="/login"><button type="button" class="btn btn-primary ">Login</button></a>
    @endguest
    @auth
        <a href="{{ route('products.index') }}"><button type="button" class="btn mt-3 ">Ga terug</button></a>
        <a href="{{ route('orders.adresses.delivery.create') }}"><button class="btn btn-primary mt-3 ">Ga verder naar de kassa</button></a>
        @endauth
</div>
</div>
@else
<h1> De winkelwagen is leeg</h1>
<h5>Zoek door onze webshop voor artikelen</h5>
    <a href="{{ route('products.index') }}" class="mt-5"><button type="button" class="btn btn-primary mb-3">Ga terug</button></a>
@endif
@endsection
@section('scripts')
@endsection