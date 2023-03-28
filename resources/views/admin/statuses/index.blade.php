@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-10">
        <h1> Statusen </h1>
    </div>
    <div class="col-2">
        <a href="/admin/statuses/create"><button class="btn btn-secondary">Nieuwe status</button></a>
    </div>
</div>

<div class="row">
    <div class="col-12 card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Naam</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statuses as $status)
                    <tr>
                        <td>{{ $status->id }}</td>
                        <td>{{ $status->name }}</td>
                        <td> <a href="{{ route('admin.statuses.edit', $status) }}"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a><a href="{{ route('admin.statuses.destroy', $status) }}"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    
</div>
@endsection
