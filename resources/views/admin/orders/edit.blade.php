@extends('layouts.admin')
@section('content')
<div class="row mt-2">
    <div class="col-12">
        <h1>Bewerk bestelling</h1>
    </div> 
</div>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('admin.orders.edit', [$order]) }}">Bewerk gegevens</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="{{ route('admin.orders.products.index', [$order]) }}">Bewerk artikelen</a>
    </li>
</ul>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="orderform" action="{{ route('admin.orders.update', $order) }}">
            
            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input value="{{old('name', $order->name)}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="street" class="col-md-4 col-form-label text-md-end">Straatnaam:</label>
                <div class="col-md-5">
                    <input class="form-control @error('street') is-invalid @enderror" value="{{ old('street', $order->street) }}"
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
                        value="{{ old('house_number', $order->house_number) }}" type="text" id="house_number" name="house_number"
                        autofocus>
                    @if ($errors->has('house_number'))
                        <div class="invalid-feedback">{{ $errors->first('house_number') }}</div>
                    @endif
                </div>
                <label for="addition" class="col-md-2 col-form-label text-md-end">Toevoeging:</label>
                <div class="col-md-1">
                    <input class="form-control @error('addition') is-invalid @enderror" value="{{ old('addition', $order->addition) }}"
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
                        value="{{ old('zipcode', $order->zipcode) }}" type="text" name="zipcode" autofocus>
                    @if ($errors->has('zipcode'))
                        <div class="invalid-feedback">{{ $errors->first('zipcode') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="city" class="col-md-4 col-form-label text-md-end">Woonplaats:</label>
                <div class="col-md-5">
                    <input class="form-control @error('city') is-invalid @enderror" id="city"
                        value="{{ old('city', $order->city) }}" type="text" name="city" autofocus>
                    @if ($errors->has('city'))
                        <div class="invalid-feedback">{{ $errors->first('city') }}</div>
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

            <div class="row mb-3">
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