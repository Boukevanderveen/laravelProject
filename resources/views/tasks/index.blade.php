@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-10">
        <h1>Taken</h1>
    </div>
    <div class="col-2">
        @can('create', $task)
        <a href="/tasks/create"><button class="btn btn-secondary">Nieuwe taak</button></a>
        @endcan
    </div>
</div>
<div class="row">
    @can('viewAny', $task)
    @foreach($tasks as $task)
    <div class="col-4">
    <div class="card d-flex align-items-start">

        <div class="card-body">
            <h5 class="card-title">{{$task->deadline}}</h5>
            <p class="card-text">{{ $task->name }}</p>
            @isset($task->member->name)
            <p class="card-text">{{ $task->member->name }}</p>
            @endisset
            @isset($task->status->name)
            <p class="card-text">{{ $task->status->name }}</p>
            @endisset
            @can('update', $task)
            <a href="{{ route('tasks.edit', $task) }}"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a>
            @endcan
            @can('delete', $task)
            <a href="{{ route('tasks.destroy', $task) }}"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a>
            @endcan
        </div>
    </div>
</div>
@endforeach
@endcan
</div>
@endsection