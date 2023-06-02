@extends('layouts.admin')
@section('content')
    <div class="row mt-2">
        <div class="col-12">
            <h1>Bewerk product eigenschap</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="productform" action="{{ route('admin.productattributes.update', $attribute ) }}">

                <div class="row mb-3 mt-5">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('name') is-invalid @enderror" value="{{old('name', $attribute->name)}}" type="text" id="name" name="name" autofocus>
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row">
                <div class="col-7"></div>
                <div class="col-5">
                    <a href="{{ route('admin.productcategories.index') }}"><button type="button" class="btn mb-3">Ga terug</button></a>
                    <button class="btn btn-primary mb-3">Bevestig</button>
                </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
@section('scripts')
</div>
@endsection