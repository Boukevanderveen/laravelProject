@extends('layouts.admin')
@section('content')
        <div class="row mt-2">
            <div class="col-6">
                <h1> Leden </h1>
            </div>
            <div class="col-4 text-end">
                <form action="{{ route('admin.projects.members.search', $project) }}">
                    <div class="input-group">
                        <input @isset($search_term) value="{{$search_term}}" @endisset type="text" class="form-control" placeholder="Zoeken" name="search_term" id="search_term">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMemberModal" data-keyboard="true">Nieuw lid</button>
            </div>
        </div>
        @include('includes.admin.projecttabs')

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
                            @foreach($member->projects as $projectmember)
                            @if($projectmember->id == $project->id)
                            <td>{{ $projectmember->pivot->role->name  }}</td>
                            @endif
                            @endforeach
                                <form method="post" action="{{ route('admin.projects.members.membersdestroy', [$project, $member]) }}"> @csrf @method('delete')
                                    <td class="text-end"><a href="{{ route('admin.projects.members.membersedit', [$project, $member]) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $member->name }} wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
            <form method="post" name="postform" action="{{ route('admin.projects.members.membersstore', [$project]) }}">

                <div class="row mb-3 mt-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="userid" id="userid" aria-label="Default select example"   autofocus>
                            @foreach ($usersProject as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Rol:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="roleid" id="roleid" aria-label="Default select example"   autofocus>
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
      </div>
    </div>
  </div>
