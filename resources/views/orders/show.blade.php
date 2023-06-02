@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Bestelling {{$order->id}}</h1>
    </div>
</div>
<div class="row">
<table id="cart" class="table table-hover table-condensed">
    <tbody>
    <div class="col card">
            @foreach($order->orderdetails as $product)
            <div role="button" onclick="location.href='{{ route('products.show', $product->product_id) }}';" class="row border-bottom mt-2">
            @if($product->product_picture) 
            <div class="col-2 hidden-xs"><img src="{{ asset('images/products/'.$product->product_id.'/'.$product->product_picture.'') }}" width="120" height="80" /></div>
            @else
            <div class="col-2 hidden-xs"><img src="{{ asset('images/default-image.png') }}" width="120" height="80"/></div>
            @endif

            <div class="col-6">
            <h6>{{ $product->product_name }}</h6>
            <h6>Aantal: {{ $product->quantity }}</h6>
            
            </div>
            <div class="col-1">
                <h6><b>Prijs</b></h6>
                <h6>€ {{ str_replace('.', ',', number_format($product->product_price , 2))}}</h6>
            </div>
            <div class="col-1">
                <h6><b>BTW</b></h6>
                <h6>€ {{ str_replace('.', ',', number_format($product->vat/100 * $product->product_price, 2))}}</h6>
            </div>
            <div class="col-2">
                <h6><b>Totaal</b></h6>
                <h6>€ {{ str_replace('.', ',', number_format($product->vat/100 * $product->product_price * $product->quantity + $product->product_price * $product->quantity  , 2))}}</h6>
            </div>
        </div>
    @endforeach

    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <h3>Details bestelling</h3>
    </div>
    <div class="col-3">
        <h6><b>Bestellingsnummer</b></h6>
        <h6>{{$order->id}}</h6>
        <h6><b>Besteld op</b></h6>
        <h6>{{date('d-m-Y', strtotime($order->created_at))}}</h6>
    </div>
    <div class="col-3">
        <h6><b>Afleveradres</b></h6>
        <h6>{{$shipmentAdress->name}}</h6>
        <h6>{{$shipmentAdress->street}} {{$shipmentAdress->house_number}}{{$shipmentAdress->addition}}</h6>
        <h6>{{$shipmentAdress->zipcode}} {{$shipmentAdress->city}}</h6>
    </div>
    <div class="col-3">
        <h6><b>Factuuradres</b></h6>
        <h6>{{$invoiceAdress->name}}</h6>
        <h6>{{$invoiceAdress->street}} {{$invoiceAdress->house_number}}{{$invoiceAdress->addition}}</h6>
        <h6>{{$invoiceAdress->zipcode}} {{$invoiceAdress->city}}</h6>
    </div>
    <div class="col-3">
        <h6><b>Kostenoverzicht</b></h6>
        <h6>Totaal excl. € {{ str_replace('.', ',', number_format($order->total_excl , 2))}}</h6>
        <h6 class="border-bottom">Totaal BTW. € {{ str_replace('.', ',', number_format($order->vat , 2))}}</h6>
        <h6>Totaal incl. € {{ str_replace('.', ',', number_format($order->total_incl , 2))}}</h6>
    </div>
</div>
            
</table>
</div>
@endsection