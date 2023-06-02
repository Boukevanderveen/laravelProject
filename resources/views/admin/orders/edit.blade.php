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
        <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"  aria-current="page" href="{{ route('admin.orders.edit', $order) }}">Bewerk gegevens</a>
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
<div class="row">
    <div class="col-12 card">
        <form method="post" name="orderform" action="{{ route('admin.orders.update', $order) }}">


            <div class="row mb-3 mt-4">
                <label class="col-md-4 col-form-label text-md-end"> Totaal (excl. btw): €</label>
                <div class="col-md-5">
                    <input value="{{str_replace('.', ',', number_format($order->total_excl, 2))}}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> Totaal btw: €</label>
                <div class="col-md-5">
                    <input value="{{str_replace('.', ',', number_format($order->vat, 2))}}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> Totaal (incl. btw): €</label>
                <div class="col-md-5">
                    <input value="{{str_replace('.', ',', number_format($order->total_incl, 2))}}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> Besteld op:</label>
                <div class="col-md-5">
                    <input value="{{date('d-m-Y H:i:s' , strtotime($order->created_at))}}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> Laatst bewerkt op:</label>
                <div class="col-md-5">
                    <input value="{{date('d-m-Y H:i:s', strtotime($order->updated_at))}}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" disabled>
                </div>
            </div>

            <div class="row">
            <div class="col-7"></div>
            <div class="col-5">
                <a href="{{ route('admin.orders.index') }}"><button type="button" class="btn mb-3">Ga terug</button></a>
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection