@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Bewerk gebruiker</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 card">
        @foreach($user as $user)
        <form method="post" name="userform" action="/admin/users/update">
            <input value="{{$user->id}}" name="id" type="hidden"> 
            
            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input value="{{old('name', $user->name)}}" id="name" type="text" class="form-control" name="name" autofocus>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">E-mail:</label>
                <div class="col-md-5">
                    <input value="{{old('email', $user->email)}}" id="email" type="text" class="form-control" name="email" autofocus>
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">Wachtwoord:</label>
                <div class="col-md-5">
                    <input id="password" type="password" class="form-control" name="password" autofocus>
                </div>
            </div>
            @csrf
            <div class="row">
            <div class="col-7"></div>
            <div class="col-3">
                <a href="/admin/users"><button type="button" class="btn btn-secondary mb-3">Ga terug</button></a>
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