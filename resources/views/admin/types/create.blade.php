@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Creëer product type</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="attributeform" action="{{ route('admin.types.store') }}">
            <input type="hidden"> 

            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input value="{{old('name')}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"   autofocus>
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
            <label for="attributes[]" class="col-md-4 col-form-label text-md-end">Attributen:</label>
            <div class="col-md-5">
                <select class="js-example-basic-multiple" id="attributes[]" name="attributes[]" multiple="multiple">
                    @if(null !== old('attributes'))
                    @foreach(old('attributes') as $attributeid)
                    <option  selected value="{{ $attributeid }}">{{ \App\Models\Attribute::find($attributeid)->name }}</option>
                    @endforeach
                    @endif
                    @foreach ($attributes as $attribute)
                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

            <div class="row">
            <div class="col-7"></div>
            <div class="col-5">
                <a href="{{ route('admin.types.index') }}"><button type="button" class="btn mb-3">Ga terug</button></a>
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
            </div>
            @csrf
        </form>
    </div>
</div>
    <script>
        $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
        $(".js-example-basic-multiple").select2({ width: '100%' });      

    });
</script>
@endsection