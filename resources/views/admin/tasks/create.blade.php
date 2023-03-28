@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Creëer taak</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="taskform" action="/admin/tasks/store">
            <input type="hidden"> 

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
                <label for="project" class="col-md-4 col-form-label text-md-end">Project:</label>
                <div class="col-md-5">
                    <select class="form-select @error('project') is-invalid @enderror" name="project" id="project" aria-label="Default select example">
                        <option selected></option>
                        @foreach ($projects as $project)
                        <option value="{{$project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('projects'))
                    <div class="invalid-feedback">{{ $errors->first('projects') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="assigned_to" class="col-md-4 col-form-label text-md-end">Toegewezen aan:</label>
                <div class="col-md-5">
                    <select class="form-select @error('assigned_to') is-invalid @enderror" name="assigned_to" id="assigned_to" aria-label="Default select example">
                        <option selected></option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                <a href="/admin/tasks"><button type="button" class="btn btn-secondary mb-3">Ga terug</button></a>
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection