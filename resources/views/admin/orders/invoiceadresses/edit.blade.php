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
        <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"  aria-current="page" href="{{ route('admin.orders.edit', $order) }}">Overzicht</a>
    </li>
    <li class="nav-item">
        <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"   aria-current="page" href="{{ route('admin.orders.shipmentadresses.edit', [$order, $shipmentAdress]) }}">Bezorgadres</a>
    <li class="nav-item">
        <a  class="nav-link active"   aria-current="page" href="{{ route('admin.orders.invoiceadresses.edit', [$order, $invoiceAdress]) }}">Factuuradres</a>
    </li>
    <li class="nav-item">
        <a  class="nav-link {{ Str::endsWith(url()->current(), 'closed') ? 'active' : '' }}"   aria-current="page" href="{{ route('admin.orders.products.index', $order) }}">Producten</a>
    </li>

</ul>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="orderform" action="{{ route('admin.orders.invoiceadresses.update', [$order, $invoiceAdress]) }}">
            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input value="{{old('name', $invoiceAdress->name)}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="street" class="col-md-4 col-form-label text-md-end">Straatnaam:</label>
                <div class="col-md-5">
                    <input class="form-control @error('street') is-invalid @enderror" value="{{ old('street', $invoiceAdress->street) }}"
                        type="text" id="street" name="street" autofocus>
                    @if ($errors->has('street'))
                        <div class="invalid-feedback">{{ $errors->first('street') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="house_number" class="col-md-4 col-form-label text-md-end">Huisnummer:</label>
                <div class="col-md-2">
                    <input class="form-control @error('house_number') is-invalid @enderror"
                        value="{{ old('house_number', $invoiceAdress->house_number) }}" type="text" id="house_number" name="house_number"
                        autofocus>
                    @if ($errors->has('house_number'))
                        <div class="invalid-feedback">{{ $errors->first('house_number') }}</div>
                    @endif
                </div>
                <label for="addition" class="col-md-2 col-form-label text-md-end">Toevoeging:</label>
                <div class="col-md-1">
                    <input class="form-control @error('addition') is-invalid @enderror" value="{{ old('addition', $invoiceAdress->addition) }}"
                        type="text" id="addition"name="addition" autofocus>
                    @if ($errors->has('addition'))
                        <div class="invalid-feedback">{{ $errors->first('addition') }}</div>
                    @endif
                </div>

            </div>

            <div class="row mb-3">
                <label for="zipcode" class="col-md-4 col-form-label text-md-end">Postcode:</label>
                <div class="col-md-5">
                    <input class="form-control @error('zipcode') is-invalid @enderror" id="zipcode"
                        value="{{ old('zipcode', $invoiceAdress->zipcode) }}" type="text" name="zipcode" autofocus>
                    @if ($errors->has('zipcode'))
                        <div class="invalid-feedback">{{ $errors->first('zipcode') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="city" class="col-md-4 col-form-label text-md-end">Woonplaats:</label>
                <div class="col-md-5">
                    <input class="form-control @error('city') is-invalid @enderror" id="city"
                        value="{{ old('city', $invoiceAdress->city) }}" type="text" name="city" autofocus>
                    @if ($errors->has('city'))
                        <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="phone_number" class="col-md-4 col-form-label text-md-end">Telefoon:</label>
                <div class="col-md-5">
                    <input class="form-control @error('phone_number') is-invalid @enderror" value="{{old('phone_number', $shipmentAdress->phone_number)}}"
                        type="text" id="phone_number" name="phone_number" autofocus>
                    @if ($errors->has('phone_number'))
                        <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">E-mail:</label>
                <div class="col-md-5">
                    <input value="{{old('email', $order->email)}}" id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" autofocus>
                    @if ($errors->has('email'))
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
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