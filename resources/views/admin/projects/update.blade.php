@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button"
                        role="tab" aria-controls="edit" aria-selected="true">Project</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button"
                        role="tab" aria-controls="members" aria-selected="false">Leden</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#project_roles"
                        type="button" role="tab" aria-controls="project_roles" aria-selected="false">Rollen</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                <div class="row mt-2">
                    <div class="col-12">
                        <h1> Project </h1>
                    </div>
                </div>
                <div class="col-12 card">
                    <form method="post" name="projectform" action="/admin/projects/update">
                        <input value="{{ $project->id }}"name="id" type="hidden">

                        <div class="row mb-3  mt-4">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Titel:</label>
                            <div class="col-md-5">
                                <input value="{{ $project->name }}" id="name" type="text" class="form-control"
                                    name="name" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                            <div class="col-md-5">
                                <input value="{{ $project->description }}" id="description" type="text"
                                    class="form-control" name="description" required autofocus>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8"></div>
                            <div class="col-4">
                                <button class="btn btn-primary mb-3">Submit</button>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>

            <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                <div class="row">
                    <div class="row mt-2">
                        <div class="col-10">
                            <h1> Leden </h1>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMemberModal" data-keyboard="true">Nieuw lid</button>
                        </div>
                    </div>
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
                                        <td><a href="members/{{ $member->id }}/update"><button
                                                    class="btn btn-link link-dark"><i
                                                        class="fa fa-pencil"></i></button></a><a
                                                href="/admin/projects/members/{{ $member->id }}/{{ $project->id }}/delete"><button
                                                    class="btn btn-link link-dark"><i
                                                        class="fa fa-trash-o"></i></button></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="project_roles" role="tabpanel" aria-labelledby="project_roles-tab">
                <div class="row mt-2">
                    <div class="col-10">
                        <h1> Rollen </h1>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRoleModal" data-keyboard="true">Nieuwe rol</button>
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
                                        <td> <a href="/admin/roles/{{ $role->id }}/edit"><button
                                                    class="btn btn-link link-dark"><i
                                                        class="fa fa-pencil"></i></button></a><a
                                                href="/admin/roles/{{ $role->id }}/delete"><button
                                                    class="btn btn-link link-dark"><i
                                                        class="fa fa-trash-o"></i></button></a></td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade modal-lg" id="newMemberModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Nieuw lid</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body">
            <form method="post" name="postform" action="members/create">

                <div class="row mb-3 mt-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="name" id="name" aria-label="Default select example" required autofocus>
                            <option selected></option>
                            @foreach ($users as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Rol:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="role" id="role" aria-label="Default select example" required autofocus>
                            <option selected></option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
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
  
        <div class="modal-footer">

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
            <form method="post" name="projectroleform" action="/admin/roles/create">
            <input type="hidden"> 

            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                </div>
            </div>

            <div class="row">
            <div class="col-8"></div>
            <div class="col-4">
                <button class="btn btn-primary mb-3">Submit</button>
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
