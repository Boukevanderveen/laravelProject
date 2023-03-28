@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Creëer rol</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="projectroleform" action="/admin/roles/store">
            <input type="hidden"> 

            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input value="{{old('name')}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="status" class="col-md-4 col-form-label text-md-end">Open/Afgerond:</label>
                <div class="col-md-5">
                    <select class="form-select @error('is_open') is-invalid @enderror" name="is_open" id="is_open" aria-label="Default select example">
                        <option selected></option>
                        <option value="1">Open</option>
                        <option value="0">Afgerond</option>
                    </select>
                    @if ($errors->has('is_open'))
                    <div class="invalid-feedback">{{ $errors->first('is_open') }}</div>
                    @endif
                </div>
            </div>
            
            <div class="row">
            <div class="col-7"></div>
            <div class="col-5">
                <a href="/admin/roles"><button type="button" class="btn btn-secondary mb-3">Ga terug</button></a>
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection