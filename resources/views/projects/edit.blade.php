@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation" a href="#home">
                    <form action="#general"> <button type="submit" href="#messages" class="nav-link active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button"
                        role="tab" aria-controls="edit" aria-selected="true">Project</button> </form>
                </li>
                <form action="#members"><li class="nav-item" role="presentation">
                    <button type="submit"class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button"
                        role="tab" aria-controls="members" aria-selected="false">Leden</button>
                </li>
            </form>
                <form action="#roles"> <li class="nav-item" role="presentation">
                    <button type="submit" class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#roles"
                        type="button" role="tab" aria-controls="roles" aria-selected="false">Rollen</button>
                </form></li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#opentasks"
                        type="button" role="tab" aria-controls="opentasks" aria-selected="false">Open taken</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#closedtasks"
                        type="button" role="tab" aria-controls="closedtasks" aria-selected="false">Afgeronde taken</button>
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
                    <form method="post" name="projectform" action="/projects/update"> <!-- route('route', $model) -->
                        <input value="{{ $project->id }}"name="id" type="hidden">

                        <div class="row mb-3  mt-4">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Titel:</label>
                            <div class="col-md-5">
                                <input value="{{ $project->name }}" id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name"   autofocus>
                                    @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                            <div class="col-md-5">
                                <input value="{{ $project->description }}" id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"   autofocus>
                                    @if ($errors->has('description'))
                                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                    @endif
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
                
<div class="row">
@can('viewAnyMember', $project)
@foreach($members as $member)
    <div class="col-4">
    <div class="card d-flex align-items-start">
       
        <div class="card-body">
            <h5 class="card-title">{{$member->name}}</h5>
            <p class="card-text">{{ $member->role }}</p>

            @can('updateMember', $project)
            <a href="members/{{ $member->id }}/update"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a>            
            @endcan
            @can('deleteMember', $project)
            <a href="/projects/members/{{ $member->id }}/{{ $project->id }}/delete"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a>            
            @endcan
        </div>
    </div>
</div>
@endforeach
@endcan
</div>
                </div>
            </div>
            <div class="tab-pane fade" id="opentasks" role="tabpanel" aria-labelledby="opentasks-tab">
                <div class="row mt-2">
                    <div class="col-10">
                        <h1> Open taken </h1>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newTaskModal" data-keyboard="true">Nieuwe taak</button>
                    </div>
                </div>

                <div class="row">
                    @can('viewAnyTask', $project)
                    @foreach($openTasks as $task)
                    <div class="col-4">
                    <div class="card d-flex align-items-start">

                        <div class="card-body">
                            <h5 class="card-title">{{$task->deadline}}</h5>
                            <p class="card-text">{{ $task->name }}</p>
                            <p class="card-text">{{ $task->member->name }}</p>
                            <p class="card-text">{{ $task->status->name }}</p>

                            @can('completeAnyTask', $project)
                            <a href="{{ route('projects.tasks.complete', [$project, $task]) }}"><button lass="btn btn-link link-dark"><i class="fa fa-check"></i></a>
                            @endcan
                            @can('updateMember', $project)
                            <a href="members/{{ $member->id }}/update"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a>            
                            @endcan
                            @can('deleteMember', $project)
                            <a href="/projects/members/{{ $member->id }}/{{ $project->id }}/delete"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a>            
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
                @endcan
                </div>

                
            </div>
            <div class="tab-pane fade" id="closedtasks" role="tabpanel" aria-labelledby="closedtasks-tab">
                <div class="row mt-2">
                    <div class="col-10">
                        <h1> Afgeronde taken </h1>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newTaskModal" data-keyboard="true">Nieuwe taak</button>
                    </div>
                </div>

                <div class="row">
                    @can('viewAnyTask', $project)
                    @foreach($closedTasks as $task)
                    <div class="col-4">
                    <div class="card d-flex align-items-start">

                        <div class="card-body">
                            <h5 class="card-title">{{$task->deadline}}</h5>
                            <p class="card-text">{{ $task->name }}</p>
                            <p class="card-text">{{ $task->member->name }}</p>
                            <p class="card-text">{{ $task->status->name }}</p>

                            @can('completeAnyTask', $project)
                            <a href="{{ route('projects.tasks.complete', [$project, $task]) }}"><button lass="btn btn-link link-dark"><i class="fa fa-check"></i></a>
                            @endcan
                            @can('updateMember', $project)
                            <a href="members/{{ $member->id }}/update"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a>            
                            @endcan
                            @can('deleteMember', $project)
                            <a href="/projects/members/{{ $member->id }}/{{ $project->id }}/delete"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a>            
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
                @endcan
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
            <form method="post" name="postform" action="members/store">

                <div class="row mb-3 mt-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="name" id="name" aria-label="Default select example"   autofocus>
                            <option selected></option>
                            @foreach ($usersProject as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Rol:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="role" id="role" aria-label="Default select example"   autofocus>
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
            <form method="post" name="projectroleform" action="/roles/create">
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

  <div class="modal fade modal-lg" id="newTaskModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Nieuwe taak</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body"> 
            <form method="post" name="taskform" action="{{ route('projects.tasks.store', [$project, $task]) }}">
                <input value="{{$project->id}}"name="project" type="hidden"> 
    
                <div class="row mb-3  mt-4">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>
    
                <div class="row mb-3  mt-4">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                    <div class="col-md-5">
                        <input id="name" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autofocus>
                        @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                </div>
    
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Deadline:</label>
                    <div class="col-md-5">
                        <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" name="deadline" step="any"> 
                        @if ($errors->has('deadline'))
                        <div class="invalid-feedback">{{ $errors->first('deadline') }}</div>
                        @endif
                    </div>
                </div>
    
                <div class="row mb-3">
                    <label for="assigned_to" class="col-md-4 col-form-label text-md-end">Toegewezen aan:</label>
                    <div class="col-md-5">
                        <select class="form-select @error('assigned_to') is-invalid @enderror" name="assigned_to" id="assigned_to" aria-label="Default select example">
                            <option selected></option>
                            @foreach($project->users as $member)
                            <option value="/articles/category/">{{$member->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('assigned_to'))
                        <div class="invalid-feedback">{{ $errors->first('assigned_to') }}</div>
                        @endif
                    </div>
                </div>
    
                <div class="row mb-3">
                    <label for="status" class="col-md-4 col-form-label text-md-end">Status:</label>
                    <div class="col-md-5">
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" aria-label="Default select example">
                            <option selected></option>
                            @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('status'))
                        <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                </div>
    
                <div class="row">
                <div class="col-7"></div>
                <div class="col-5">
                    <a href="/tasks"><button type="button" class="btn btn-secondary mb-3">Ga terug</button></a>
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
  <script>

    $('#myTab a').click(function(e) {
      e.preventDefault();
      $(this).tab('show');
    });
    
    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
      var id = $(e.target).attr("href").substr(1);
      window.location.hash = id;
    });
    
    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#myTab a[href="' + hash + '"]').tab('show');
    
    </script>