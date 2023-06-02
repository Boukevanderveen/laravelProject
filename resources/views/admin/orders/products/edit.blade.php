@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Bewerk bestellingsproduct</h1>
        </div>

    </div>

    <div class="row">
        <div class="col-12 card">
    <form method="post" name="postform" action="{{ route('admin.orders.products.update', [$order, $orderdetail]) }}">
        <div class="row  mb-3 mt-5">
            <label for="role" class="col-md-4 col-form-label text-md-end">Product:</label>
            <div class="col-md-5">
                <select disabled class="form-select" name="productid" id="productid" aria-label="Default select example">
                    <option>{{ $orderdetail->product_name}} | voorraad: {{ $product->stock}}</option>
                
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="role" class="col-md-4 col-form-label text-md-end">Hoeveelheid:</label>
            <div class="col-md-5">
                <select class="form-select" name="quantity" id="quantity" aria-label="Default select example"   autofocus>
                    <option selected value="{{ $orderdetail->quantity }}">{{ $orderdetail->quantity}}</option>
                    @for ($i = 1; $i < 99; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-8"></div>
            <div class="col-4">
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
        </div>
        @csrf

    </form>
</div>
</div>

@endsection
