@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-10">
        <h1>Rollen</h1>
    </div>
    <div class="col-2">

    </div>
</div>
<div class="row">

    @foreach($roles as $role)
        <div class="col-4">
        <div class="card d-flex align-items-start">
            <div class="card-body">
                <h5 class="card-title">{{$role->name}}</h5>
    
                <a href="#" class="btn btn-primary btn-m">Bekijk</a>
                
            </div>
        </div>
    </div>
    @endforeach
    </div>
@endsection