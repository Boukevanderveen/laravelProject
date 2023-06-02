@extends('layouts.admin')
@section('content')
<div class="row mt-2">
    <div class="col-10">
        <h1>Bewerk bestelling</h1>
    </div> 
    <div class="col-2">
        <a href="{{ route('admin.orders.mail', $order) }}"><button type="button"
            class="btn btn-lg text-end"><i class='fa fa-envelope'></i></button></a>
        <a href="{{ route('admin.orders.invoice', $order) }}"><button type="button"
            class="btn btn-lg text-end"><i class='fa fa-download'></i></button></a>
            
    </div> 
</div>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a  class="nav-link active"  aria-current="page" href="{{ route('admin.orders.edit', $order) }}">Overzicht</a>
    </li>
    <li class="nav-item">
        <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"   aria-current="page" href="{{ route('admin.orders.shipmentadresses.edit', [$order, $shipmentAdress]) }}">Bezorgadres</a>
    <li class="nav-item">
        <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"   aria-current="page" href="{{ route('admin.orders.invoiceadresses.edit', [$order, $invoiceAdress]) }}">Factuuradres</a>
    </li>
    <li class="nav-item">
        <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"   aria-current="page" href="{{ route('admin.orders.products.index', $order) }}">Producten</a>
    </li>

</ul>
<div class="row mt-3">
    <div class="col-8">
        <div class="row mb-3">
        <div class="col-7">
            <h6><b>Afleveradres</b></h6>
            <h6>{{$shipmentAdress->name}}</h6>
            <h6>{{$shipmentAdress->company_name}}</h6>
            <h6>{{$shipmentAdress->street}} {{$shipmentAdress->house_number}}{{$shipmentAdress->addition}}</h6>
            <h6>{{$shipmentAdress->zipcode}} {{$shipmentAdress->city}}</h6>
            <h6>{{$shipmentAdress->phone_number}}</h6>
            <h6>{{$shipmentAdress->email}}</h6>
        </div>
        <div class="col-5">
            <h6><b>Factuuradres</b></h6>
            <h6>{{$invoiceAdress->name}}</h6>
            <h6>{{$shipmentAdress->company_name}}</h6>
            <h6>{{$invoiceAdress->street}} {{$invoiceAdress->house_number}}{{$invoiceAdress->addition}}</h6>
            <h6>{{$invoiceAdress->zipcode}} {{$invoiceAdress->city}}</h6>
            <h6>{{$shipmentAdress->phone_number}}</h6>
            <h6>{{$shipmentAdress->email}}</h6>
        </div>
    </div>
    
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
            <tbody>
                @foreach($order->orderdetails as $product)
                    <tr>
                        <td >
                            <div class="row">
                                @if($product->product_picture) 
                                <div class="col-sm-5 hidden-xs"><img src="{{ asset('images/products/'.$product->product_id.'/'.$product->product_picture.'') }}" width="80" height="80" class="img-fluid"/></div>
                                @else
                                <div class="col-sm-5 hidden-xs"><img src="{{ asset('images/default-image.png') }}" width="80" height="80" class="img-fluid"/></div>
                                @endif
                                <div class="col-sm-7">
                                    <h5 class="nomargin">{{ $product->product_name }}</h5>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">€ {{ str_replace('.', ',', number_format($product->product_price, 2))}}</td>
                        <td class="text-center">{{$product->quantity}}</td>
                        <td class="text-center">{{ str_replace('.', ',', number_format($product->vat))}}%</td>

                        <td class="text-center">€ {{ str_replace('.', ',', number_format($product->product_price * $product->quantity , 2))}}</td>
                        <td class="text-center">€ {{ str_replace('.', ',', number_format($product->product_price * $product->quantity * $product->vat/100 + $product->product_price * $product->quantity, 2))}}</td>
                        <td class="actions" data-th="">
                        </td>
                    </tr>
                @endforeach   
        </tbody>
    </table>
    </div>
    <div class="col-4">
        <ul class="list-group border">
            <div class="row">
                <div class="col-12">
                    <li class="list-group-item border-0"><h5>Samenvatting:</h5></li>
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    <li class="list-group-item border-0">Subtotaal:</li>
                    <li class="list-group-item border-0">Btw:</li>
                    <li class="list-group-item border-0">Totaal excl. btw:</li>
                    <li class="list-group-item border-0">Totaal incl. btw:</li>
                </div>
                <div class="col-5">
                    <li class="list-group-item border-0">€ {{ str_replace('.', ',', number_format((float)$order->total_excl, 2, '.', '')) }}</li>
                    <li class="list-group-item border-0">€ {{ str_replace('.', ',', number_format((float)$order->vat, 2, '.', '')) }}</li>
                    <li class="list-group-item border-0">€ {{ str_replace('.', ',', number_format((float)$order->total_excl, 2, '.', '')) }}</li>
                    <li class="list-group-item border-0">€ {{ str_replace('.', ',', number_format((float)$order->total_incl, 2, '.', '')) }}</li>
                    
                </div>
            </div>
        </ul>
    </div>
</div>
@endsection