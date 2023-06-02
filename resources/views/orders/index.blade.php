@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Mijn bestellingen</h1>
    </div>
</div>
<div class="row">
@foreach($orders as $order)
<table id="cart" class="table table-hover table-condensed">
    <tbody>
    <div role="button" class="col card" onclick="location.href='{{ route('orders.show', $order) }}';">
            <div class="row mt-2">
                <div class="col-2">
                        <h6><b>Bestelling</b></h6>
                        <h6>{{$order->id}}</h6>
                </div>
                <div class="col-10">
                    <h6><b>Besteldatum</b></h6>
                    <h6>{{date('d-m-Y', strtotime($order->created_at))}}</h6>
                </div>
            </div>
            @foreach($order->orderdetails as $product)
            <div class="row border">
            @if($product->product_picture) 
            <div class="col-2 hidden-xs mt-2"><img src="{{ asset('images/products/'.$product->product_id.'/'.$product->product_picture.'') }}" width="120" height="80" /></div>
            @else
            <div class="col-2 hidden-xs mt-2"><img src="{{ asset('images/default-image.png') }}" width="120" height="80"/></div>
            @endif

            <div class="col-10 mt-2">
            <h6>{{ $product->product_name }}</h6>
            <h6>Aantal: {{ $product->quantity }}</h6>

            </div>
        </div>
            @endforeach
        </div>
    </div>
            
</table>
@endforeach

</div>
@endsection