@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-10">
        <h1> Rollen </h1>
    </div>
    <div class="col-2">
        <a href="/admin/roles/create"><button class="btn btn-secondary">Nieuwe rol</button></a>
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
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td> <a href="{{ route('admin.roles.edit', $role) }}"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a><a href="{{ route('admin.roles.destroy', $role) }}"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a></td>
                    	
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    
</div>
@endsection
