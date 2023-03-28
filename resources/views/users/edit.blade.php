@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Bewerk gebruiker</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 card">
        @foreach($user as $user)
        <form method="post" name="userform" action="/users/update">
            <input value="{{$user->id}}" name="id" type="hidden"> 
            
            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input value="{{old('name', $user->name)}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">E-mail:</label>
                <div class="col-md-5">
                    <input value="{{old('email', $user->email)}}" id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" autofocus>
                    @if ($errors->has('email'))
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">Wachtwoord:</label>
                <div class="col-md-5">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autofocus>
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>
            </div>
            @csrf
            <div class="row">
            <div class="col-7"></div>
            <div class="col-3">
                <a href="/users"><button type="button" class="btn btn-secondary mb-3">Ga terug</button></a>
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
        </form>

            <div class="col-4">
            </div>
            </div>
        @endforeach
    </div>
</div>
@endsection