@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Gebruikers</h1>
    </div>

</div>
<div class="row">

    @foreach($users as $user)
        <div class="col-4">
        <div class="card d-flex align-items-start">
            <div class="card-body">
                <h5 class="card-title">{{$user->name}}</h5>
                <a href="#" class="btn btn-primary btn-m">Bekijk</a>
            </div>
        </div>
    </div>
    @endforeach
    </div>
@endsection