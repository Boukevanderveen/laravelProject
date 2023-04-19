@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Bewerk taak</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="tasksform" action="    {{ route('admin.tasks.update', $task) }}">
                <input value="{{$task->id}}"name="id" type="hidden"> 

                <div class="row mb-3  mt-4">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input value="{{old('name', $task->name)}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3  mt-4">
                    <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                    <div class="col-md-5">
                        <input value="{{old('description', $task->description)}}" id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autofocus>
                        @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Deadline:</label>
                    <div class="col-md-5">
                        <input value="{{old('deadline', $task->deadline)}}" type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" name="deadline" step="any"> 
                        @if ($errors->has('deadline'))
                        <div class="invalid-feedback">{{ $errors->first('deadline') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="project" class="col-md-4 col-form-label text-md-end">Project:</label>
                    <div class="col-md-5">
                        <select class="form-select @error('project') is-invalid @enderror" name="project" id="project" aria-label="Default select example">
                            <option value ="{{$task->project->name}}" selected>{{old('project', $task->project->name)}}</option>
                            @foreach ($projects as $project)
                            <option value="{{ $project->name }}" >{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('projects'))
                        <div class="invalid-feedback">{{ $errors->first('projects') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="member" class="col-md-4 col-form-label text-md-end">Toegewezen aan:</label>
                    <div class="col-md-5">
                        <select class="form-select @error('member') is-invalid @enderror" name="member" id="member" aria-label="Default select example">
                            <option value ="{{$task->member->name}}" selected>{{old('member', $task->member->name)}}</option>
                            @foreach($project->users as $member)
                            <option value="{{ $member->name}}">{{ $member->name}}</option>
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
                            <option value ="{{old('status', $task->status->name)}}" selected>{{old('status', $task->status->name)}}</option>
                            @foreach ($statuses as $status)
                            <option value="{{$status->name}}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('status'))
                        <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="completed" class="col-md-4 col-form-label text-md-end">Open/Afgerond:</label>
                    <div class="col-md-5">
                        <select class="form-select @error('completed') is-invalid @enderror" name="completed" id="completed" aria-label="Default select example">
                            
                            <option value="{{$task->completed}}"selected>
                            @if($task->completed == 1)
                            Afgerond
                            <option value="0">Open</option>
                            </option>

                            @elseif($task->completed == 0)
                            Open
                            </option>
                            <option value="1">Afgerond</option>
                             @endif

                        </select>
                        @if ($errors->has('completed'))
                        <div class="invalid-feedback">{{ $errors->first('completed') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row">
                <div class="col-7"></div>
                <div class="col-5">
                    <a href="{{ route('admin.tasks.index') }}"><button type="button" class="btn mb-3">Ga terug</button></a>
                    <button class="btn btn-primary mb-3">Bevestig</button>
                </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
