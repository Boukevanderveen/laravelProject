@extends('layouts.admin')
@section('content')
@include('includes.admin.projecttabs')
<div class="row mt-2">
    <div class="col-10">
        <h1> Afgeronde taken </h1>
    </div>
    <div class="col-2 text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newTaskModal" data-keyboard="true">Nieuwe taak</button>
    </div>
</div>

<div class="row">
    <div class="col-12 card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Taak</th>
                    <th scope="col">Medewerker</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($closedTasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->deadline->format('d-m-Y') }}</td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->member->name }}</td>
                    <td>{{ $task->status->name }}</td>
                    <td> 
                        <form method="post" action="{{ route('admin.projects.tasks.tasksdestroy', [$project, $task]) }}"> @csrf @method('delete')
                            <td class="text-end">
                                <a href="{{ route('admin.projects.tasks.tasksuncomplete', [$project, $task]) }}"><button type="button"
                                    class="btn btn-link link-dark">
                                <i class="fa fa-close"></i>
                                </button></a>
                                <a href="{{ route('admin.projects.tasks.tasksedit', [$project, $task]) }}"><button type="button" btn btn-link
                                class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                        <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $task->name }} wilt verwijderen?')"
                                class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                </tr>
                @endforeach
            </tbody>
        </table>
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
            <form method="post" name="taskform" action="{{ route('admin.projects.tasks.tasksstore', [$project]) }}">
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
                    <label for="member" class="col-md-4 col-form-label text-md-end">Toegewezen aan:</label>
                    <div class="col-md-5">
                        <select class="form-select @error('member') is-invalid @enderror" name="member" id="member" aria-label="Default select example">
                            <option selected></option>
                            @foreach($project->users as $member)
                            <option value="{{$member->id}}">{{$member->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('member'))
                        <div class="invalid-feedback">{{ $errors->first('member') }}</div>
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
                <div class="col-6"></div>
                <div class="col-6">
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
@endsection