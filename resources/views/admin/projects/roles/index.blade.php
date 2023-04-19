@extends('layouts.admin')
@section('content')
@include('includes.admin.projecttabs')

<div class="row ">
    <div class="col-10 mt-2">
        <h1> Rollen </h1>
    </div>
    <div class="col-2 text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRoleModal" data-keyboard="true">Nieuwe taak</button>
    </div>
</div>

<div class="row">
    <div class="col-12 card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Gemaakt op</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->created_at->format('d-m-Y') }}</td>

                        <form method="post" action="{{ route('admin.projects.roles.destroy', [$project, $role]) }}"> @csrf @method('delete')
                            <td class="text-end"><a href="{{ route('admin.projects.roles.edit', [$project, $role]) }}"><button type="button" btn btn-link
                                class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                        <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $role->name }} wilt verwijderen?')"
                                class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>  
                    	
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $roles->links() }}
    </div>    
</div>
@if(!$roles->isEmpty())
<div class="modal fade modal-lg" id="confirmdeletionmodal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Artikel verwijderen</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body">
            <div class="modal-body">
                Weet u zeker dat u deze rol wilt verwijderen?
               </div>
        </div>
  
        <div class="modal-footer">
            <form action="{{ route('admin.projects.roles.destroy', [$project, $role]) }}" method="get">@csrf<button type="submit" class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Toch verwijderen</button></form>
        </div>
  
      </div>
    </div>
  </div>
  <div class="modal fade modal-lg" id="newRoleModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Nieuwe rol</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body">
            <form method="post" name="projectroleform" action="{{ route('admin.projects.roles.store', $project) }}">
            <input type="hidden"> 

            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input id="name" type="text" class="form-control" name="name"   autofocus>
                </div>
            </div>

            <div class="row">
            <div class="col-8"></div>
            <div class="col-4">
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
            </div>
            @csrf
        </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  @endif
@endsection