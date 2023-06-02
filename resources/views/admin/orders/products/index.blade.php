@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-10">
            <h1>Bewerk bestelling</h1>
        </div>
        <div class="col-2 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newProductModal" data-keyboard="true">Nieuw artikel</button>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"  aria-current="page" href="{{ route('admin.orders.edit', $order) }}">Overzicht</a>
        </li>
        <li class="nav-item">
            <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"   aria-current="page" href="{{ route('admin.orders.shipmentadresses.edit', [$order, $shipmentAdress]) }}">Bezorgadres</a>
        <li class="nav-item">
            <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"   aria-current="page" href="{{ route('admin.orders.invoiceadresses.edit', [$order, $invoiceAdress]) }}">Factuuradres</a>
        </li>
        <li class="nav-item">
            <a  class="nav-link active"   aria-current="page" href="{{ route('admin.orders.products.index', $order) }}">Producten</a>
        </li>
    
    </ul>
    <div class="row">
        <div class="col-12 card">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Naam</th>
                        <th scope="col">Hoeveelheid</th>
                        <th scope="col">Prijs</th>
                        <th scope="col">Totaal</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderdetails as $orderdetail)
                    <tr>
                            <td>{{ $orderdetail->product_name }}</td>
                            <td>{{ $orderdetail->quantity }}</td>
                            <td>€ {{ str_replace('.', ',', number_format($orderdetail->product_price , 2))}}</td>
                            <td>€ {{ str_replace('.', ',', number_format($orderdetail->product_price * $orderdetail->quantity, 2))}}</td>
                            <form method="post" action="{{ route('admin.orders.products.destroy', [$order, $orderdetail]) }}"> @csrf @method('delete')
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.products.edit', [$order, $orderdetail]) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                            <button type="submit" onclick="return confirm('Weet je zeker dat je het artikel {{ $orderdetail->product_name }} van deze bestelling wilt verwijderen?')"
                                    class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<div class="modal fade modal-lg" id="newProductModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Nieuw lid</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body">
            <form method="post" name="postform" action="{{ route('admin.orders.products.store', [$order]) }}">
                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Product:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="productid" id="productid" aria-label="Default select example"   autofocus>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name}} | voorraad: {{ $product->stock}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Hoeveelheid:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="quantity" id="quantity" aria-label="Default select example"   autofocus>
                            @for ($i = 1; $i < 99; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <button class="btn btn-primary mb-3">Toevoegen</button>
                    </div>
                </div>
                @csrf

            </form>
        </div>
      </div>
    </div>
  </div>

