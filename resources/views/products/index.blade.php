@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Producten</h1>
    </div>
</div>
<div class="row">

@foreach($products as $product)
    <div class="col-3"> 

    <div role="button" class="card d-flex align-items-start" onclick="location.href='{{ route('products.show', $product) }}';">
        @if($product->picture) 
        <img class="card-img-top" height="200" src="{{ asset('images/products/'.$product->id.'/'.$product->picture.'') }}"/>
        @else
        <img class="card-img-top" height="200" src="{{ asset('images/default-image.png') }}"/>
        @endif
        <div class="card-body">
            <h5 class="card-title">{{$product->name}}</h5>
            @if(isset($product->discount_price))
            <p class="card-text text-decoration-line-through">€ {{str_replace('.', ',', $product->price)}}</p>
            <p class="card-text position-absolute">€ {{str_replace('.', ',', $product->discount_price)}}</p>
            
            @else
            <p class="card-text">€ {{str_replace('.', ',', $product->price)}}</p>
            
            @endif
            <br>
            <div class="row">
            <form action="{{ route('products.add.to.cart', $product->id) }}" method="POST">
            @csrf
            <input name="productid" type="hidden" value="{{$product->id}}">
            @if($product->stock > 0)
            @if(isset( Session::get('cart')[$product->id]))
            @if(Session::get('cart')[$product->id]['quantity'] < Session::get('cart')[$product->id]['stock'])
            <p class="btn-holder"><button class="btn btn-m btn btn-outline-secondary"type="submit"><b>+</b><i class="fa fa-shopping-cart"></i> </button> </p>
            @endif
            @if(Session::get('cart')[$product->id]['quantity'] >= Session::get('cart')[$product->id]['stock'])
            <p class="btn-holder"><button class="btn btn-m btn btn-outline-secondary" disabled type="submit"><b>+</b><i class="fa fa-shopping-cart"></i> </button> </p>
            @endif
            @else
            <p class="btn-holder"><button class="btn btn-m btn btn-outline-secondary"type="submit"><b>+</b><i class="fa fa-shopping-cart"></i> </button> </p>
            @endif
            @else
            <p class="btn-holder"><button class="btn btn-m btn btn-outline-secondary" disabled><b>Niet op voorraad</b></button> </p>
            @endif
            
            </form>
            <a href="{{ route('products.show', $product) }}" class="btn btn-primary">Bekijk product</a>
            </div>
        </div>
    </div>
</div>
@endforeach
</div>
@endsection