@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-3">
            <ul id="ul1" class="list-group list-group-flush">
                <li class="list-group-item"><b>Eigenschappen</b></li>

                @php
                $used = array();
                @endphp
                <form method="post" action="{{ route('products.indexattributes') }}">
                @csrf
                
                @foreach ($attributes as $attribute)
                @if($attribute->values->isNotEmpty())
                <li class="list-group-item border-0">{{$attribute->name}}:</li>
                @endisset
                @php $count = 0; @endphp
                <script>
                    var attributeCheckBoxId = 0;
                </script>
                        @php $count++; @endphp
                        <script>
                            attributeCheckBoxId += 1;
                        </script>

                        <li class="list-group-item border-0">

                            @foreach($attribute->values->unique('value') as $value)
                            <div class="row">
                            <div class="col">
                            <input onclick="this.form.submit();" name="{{ $value->id }}" class="form-check-input"
                                type="checkbox" value="{{ $attribute->id}},{{ $value->id}}" id="attributevalue_{{ $value->id }}">
                                <label for="flexCheckDefault" class="">{{ $value->value }}</label>
                            </div>
                            </div>
                                @endforeach
                        </li>
                @endforeach
            </form>

            </ul>
            <form method="post" action="{{ route('products.indexprice') }}">
            @csrf
                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item">Prijs (€)</li>
                    <li class="list-group-item border-0">

                        <div class="row">

                            <div class="col-5">
                                <input  @isset($minPrice) value="{{ str_replace('.', ',', $minPrice) }}"@endisset
                                    name="min_price" id="min_price_input" class="form-control">
                            </div>
                            <div class="col-2">
                                <h5>_</h5>
                            </div>
                            <div class="col-5">
                                <input  @isset($maxPrice) value="{{ str_replace('.', ',', $maxPrice) }}"@endisset name="max_price" id="max_price_input" class="form-control">
                            </div>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
        <div class="col-9">
            <h1>{{$category->name}}</h1>
            @php $count = 0; @endphp
            <div class="row">
                @php $count = 0; @endphp

                @foreach ($products as $product)
                    @php $count++; @endphp
                    <div class="col-4">
                        <div role="button" class="card d-flex align-items-start mb-3"
                            onclick="location.href='{{ route('products.show', $product) }}';">

                            @if ($product->picture)
                                <img class="card-img-top" height="200"
                                    src="{{ asset('images/products/' . $product->id . '/' . $product->picture . '') }}" />
                            @else
                                <img class="card-img-top" height="200" src="{{ asset('images/default-image.png') }}" />
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                @if (isset($product->discount_price))
                                    <p class="card-text text-decoration-line-through">€
                                        {{ str_replace('.', ',', $product->price) }}</p>
                                    <p class="card-text position-absolute">€
                                        {{ str_replace('.', ',', $product->discount_price) }}</p>
                                @else
                                    <p class="card-text">€ {{ str_replace('.', ',', $product->price) }}</p>
                                @endif
                                <br>
                                <div class="row">
                                    <form action="{{ route('products.add.to.cart', $product->id) }}" method="POST">
                                        @csrf
                                        <input name="productid" type="hidden" value="{{ $product->id }}">
                                        @if ($product->stock > 0)
                                            @if (isset(Session::get('cart')[$product->id]))
                                                @if (Session::get('cart')[$product->id]['quantity'] < Session::get('cart')[$product->id]['stock'])
                                                    <p class="btn-holder"><button
                                                            class="btn btn-m btn btn-outline-secondary"type="submit"><b>+</b><i
                                                                class="fa fa-shopping-cart"></i> </button> </p>
                                                @endif
                                                @if (Session::get('cart')[$product->id]['quantity'] >= Session::get('cart')[$product->id]['stock'])
                                                    <p class="btn-holder"><button
                                                            class="btn btn-m btn btn-outline-secondary" disabled
                                                            type="submit"><b>+</b><i class="fa fa-shopping-cart"></i>
                                                        </button> </p>
                                                @endif
                                            @else
                                                <p class="btn-holder"><button
                                                        class="btn btn-m btn btn-outline-secondary"type="submit"><b>+</b><i
                                                            class="fa fa-shopping-cart"></i> </button> </p>
                                            @endif
                                        @else
                                            <p class="btn-holder"><button class="btn btn-m btn btn-outline-secondary"
                                                    disabled><b>Niet op voorraad</b></button> </p>
                                        @endif

                                    </form>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-primary">Bekijk
                                        product</a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            {{ $products->links() }}

        </div>
            <script>
                var min_value_input = document.getElementById("min_price_input");
                min_value_input.addEventListener("keypress", function(event) {
                  if (event.key === "Enter") {
                    this.form.submit();
                    }
                });

                var max_value_input = document.getElementById("max_price_input");
                max_value_input.addEventListener("keypress", function(event) {
                  if (event.key === "Enter") {
                    this.form.submit();
                    }
                });
                </script>
                @isset($selectedAttributeValues)
                @foreach($selectedAttributeValues as $key => $value)
                @foreach($value as $value)

                @php
                echo'
                <script type="text/javascript">
                    var value = "attributevalue_'.$value.'"     
                    document.getElementById(value).checked = true;
                    
                </script>
                '
                @endphp
                @endforeach
                @endforeach
                @endisset

        @endsection