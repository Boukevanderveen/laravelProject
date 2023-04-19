@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Projecten</h1>
    </div>
</div>
<div class="row">

@foreach($projects as $project)
    
    <div class="col-4">
    <div class="card d-flex align-items-start">
        <div class="card-body">
            <h5 class="card-title">{{$project->name}}</h5>
            <p class="card-text">{{$project->description}}</p>

            <a href="{{ route('projects.show', $project) }}" class="btn btn-primary btn-m">Bekijk project</a>
        </div>
    </div>
</div>
@endforeach
</div>
@endsection