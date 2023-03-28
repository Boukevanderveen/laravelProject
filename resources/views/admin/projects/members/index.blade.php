@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-10">
        <h1>{{$project->name}} leden</h1>
    </div>
    <div class="col-2">
        <h1><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-keyboard="true">
            Lid toevoegen
          </button>
        </h1>    
    </div>
</div>
    <div class="row">
        <div class="col-12 card">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Rol</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->pivot->role }}</td>
                            <td><a href="members/{{$member->id}}/update"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a><a href="/admin/projects/members/{{ $member->id }}/{{$project->id}}/delete"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a></td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
@endsection
  
  <!-- The Modal -->
  <div class="modal fade modal-lg" id="myModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Lid toevoegen</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
            <form method="post" name="postform" action="members/create">

                <div class="row mb-3 mt-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input type="name" id="name" name="name" class="form-control" autofocus />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Rol:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="role" id="role" aria-label="Default select example" autofocus>
                            <option selected></option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <button class="btn btn-primary mb-3">Toevoegen</button>
                    </div>
                </div>
                @csrf

            </form>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">

        </div>
  
      </div>
    </div>
  </div>