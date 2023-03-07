@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-10">
        <h1> Projecten </h1>
    </div>
    <div class="col-2">
        <a href="/admin/projects/create"><button class="btn btn-secondary">Nieuw project</button></a>
    </div>
</div>

<div class="row">
    <div class="col-12 card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Beschrijving</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->description }}</td>
                        <td><a href="/admin/projects/{{ $project->id }}/edit"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a><a href="/admin/projects/{{ $project->id }}/delete"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    
</div>
@endsection
