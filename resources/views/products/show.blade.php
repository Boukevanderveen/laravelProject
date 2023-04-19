@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-3">
        @if($product->picture) 
                <img class="card-img-top" height="200" src="{{ asset('images/products/'.$product->id.'/'.$product->picture.'') }}"/>
                @else
                <img class="card-img-top" height="200" src="{{ asset('images/default-image.png') }}"/>
        @endif
        
        </div>
        
<div class="col-6">
    <h1>{{$product->name}}</h1>

    @if(isset($product->discount_price))
    <div class="row ">
        <div class="col-2">
            <p class="text-decoration-line-through">€ {{str_replace('.', ',', $product->price)}}</p>
        </div>
        <div class="col-10">
            <p>€ {{str_replace('.', ',', $product->discount_price)}}</p>
        
        </div>
         
    </div>
    @else
    <p>€ {{str_replace('.', ',', $product->price)}}</p>
    @endif
   

    {!! $product->description !!}


    <div class="row">
    <div class="col-6">
    <form action="{{ route('products.add.to.cart') }}" method="POST">
        @csrf
        <input name="productid" type="hidden" value="{{$product->id}}">
        @if($product->stock > 0)
        <p>Voorraad: {{$product->stock}}</p>
        @endif
            @if($product->stock > 0)
            <div class="row ">
                <div class="col-4">
                    <select class="form-select @error('category') is-invalid @enderror" name="quantity" id="quantity" aria-label="Default select example">
                        @if($itemsInCart > 0) 
                        <option value="{{$itemsInCart}}" selected>{{$itemsInCart}}</option>
                        @else
                        <option value="1" selected>1</option>
                        @endif
                        @for ($i = 1; $i < $product->stock+1 && $i < 100; $i++ )
                        @if($i != $itemsInCart)
                        <option value="{{$i}}">{{$i}}</option>
                        @endif
                        @endfor
                    </select>
                </div>
                <div class="col-8">
                    <p class="btn-holder"><button class="btn btn-primary"type="submit"><b>+</b><i class="fa fa-shopping-cart"></i> In winkelmandje</button></p>
                </div>
                 
                </div>
            <div class="col-3">
                
            </div>
            @else
            <p class="btn-holder"><button class="btn btn-m btn btn-outline-secondary" disabled><b>Niet op voorraad</b></button> </p>

            <a href="{{ route('products.index') }}" class="mt-5"><button type="button" class="btn btn-primary mb-3">Ga terug</button></a>

            @endif
    </div>
    
    </form>

</div>
</div>

@endsection 