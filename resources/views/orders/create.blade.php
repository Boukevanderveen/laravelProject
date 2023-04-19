@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">

            <h1>Bestelling afronden</h1>
        </div>
    </div>
    @php 
    $total = 0;
    $total_vat = 0;
    @endphp
    @foreach(session('cart') as $id => $details)
        @if(isset($details['discount_price']))
        @php $total += $details['discount_price'] * $details['quantity'];
        $total_vat += $details['discount_price'] * $details['quantity'] * $details['vat']/100 + ($details['discount_price'] * $details['quantity']) @endphp
        @else
        @php $total += $details['price'] * $details['quantity'];
        $total_vat +=  $details['price'] * $details['quantity'] * $details['vat']/100 + ($details['price'] * $details['quantity']) @endphp
        @endif
    @endforeach
    <div class="row">
        <div class="col-9 card">
            <form method="post" name="productform" action="{{ route('orders.store') }}">

                <div class="row mb-3 mt-5">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                            value="{{ old('name') }}" type="text" name="name" autofocus>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="street" class="col-md-4 col-form-label text-md-end">Straatnaam:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}"
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
                            value="{{ old('house_number') }}" type="text" id="house_number" name="house_number"
                            autofocus>
                        @if ($errors->has('house_number'))
                            <div class="invalid-feedback">{{ $errors->first('house_number') }}</div>
                        @endif
                    </div>
                    <label for="addition" class="col-md-2 col-form-label text-md-end">Toevoeging:</label>
                    <div class="col-md-1">
                        <input class="form-control @error('addition') is-invalid @enderror" value="{{ old('addition') }}"
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
                            value="{{ old('zipcode') }}" type="text" name="zipcode" autofocus>
                        @if ($errors->has('zipcode'))
                            <div class="invalid-feedback">{{ $errors->first('zipcode') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="city" class="col-md-4 col-form-label text-md-end">Woonplaats:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('city') is-invalid @enderror" id="city"
                            value="{{ old('city') }}" type="text" name="city" autofocus>
                        @if ($errors->has('city'))
                            <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">E-mail:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            type="text" id="email" name="email" autofocus>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <a href="{{ route('products.cart') }}"><button type="button" class="btn mb-3">Ga
                                terug</button></a>
                        <button type="submit" class="btn btn-primary mb-3">Bevestig</button>
                    </div>
                </div>
                <input name="total" type="hidden" value="{{ $total }}">
                <input name="total_vat" type="hidden" value="{{ $total_vat }}">
                @csrf
            </form>
        </div>
        <div class="col-3">
            <ul class="list-group border">
                <li class="list-group-item border-0">
                    <h5>Samenvatting:</h5>
                </li>
                <li class="list-group-item border-0">Subtotaal: €
                    {{ str_replace('.', ',', number_format((float) $total, 2, '.', '')) }}</li>
                <li class="list-group-item border-0">Btw: €
                    {{ str_replace('.', ',', number_format((float) $total_vat - $total, 2, '.', '')) }}</li>
                <li class="list-group-item border-0"></li>
                <li class="list-group-item border-0">Totaal excl. btw: €
                    {{ str_replace('.', ',', number_format((float) $total, 2, '.', '')) }}</li>
                <li class="list-group-item border-0">Totaal incl. btw: €
                    {{ str_replace('.', ',', number_format((float) $total_vat, 2, '.', '')) }}</li>
            </ul>
        </div>
    </div>
@endsection
