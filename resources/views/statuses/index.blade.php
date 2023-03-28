@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-10">
        <h1>Stasusen</h1>
    </div>
    <div class="col-2">
        @can('create', $status)
        <a href="/statuses/create"><button class="btn btn-secondary">Nieuwe taak</button></a>
        @endcan
    </div>
</div>
<div class="row">
    @can('viewAny', $status)
    @foreach($statuses as $status)
    <div class="col-4">
    <div class="card d-flex align-items-start">

        <div class="card-body">
            <h5 class="card-title">{{$status->name}}</h5>

            @can('update', $status)
            <a href="{{ route('statuses.edit', $status) }}"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a>
            @endcan
            @can('delete', $status)
            <a href="{{ route('statuses.destroy', $status) }}"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a>
            @endcan
        </div>
    </div>
</div>
@endforeach
@endcan
</div>
@endsection