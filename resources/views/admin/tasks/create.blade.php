@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Creëer taak</h1>
    </div>
</div>
<script>
// In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="taskform" action="/admin/tasks/store">
            <input type="hidden"> 

            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input value="{{ old('name') }}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3  mt-4">
                <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                <div class="col-md-5">
                    <input value="{{ old('description') }}" id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autofocus>
                    @if ($errors->has('description'))
                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="deadline" class="col-md-4 col-form-label text-md-end">Deadline:</label>
                <div class="col-md-5">
                    <input value="{{ old('deadline') }}" id="deadline" type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" name="deadline" step="any"> 
                    @if ($errors->has('deadline'))
                    <div class="invalid-feedback">{{ $errors->first('deadline') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="project" class="col-md-4 col-form-label text-md-end">Project:</label>
                <div class="col-md-5">
                    <select placeholder="Selecteer een project" class="form-select js-example-basic-single @error('project') is-invalid @enderror" name="project" id="project" aria-label="Default select example">
                        @if(is_null( old('project')))
                        <option value="" disabled selected>Selecteer een project...</option>
                        @else
                        <option value ="{{old('project')}}" selected>{{old('project')}}</option>
                        @endif
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
                    <select class="js-example-basic-single form-select @error('member') is-invalid @enderror" name="member" id="member" aria-label="Default select example">
                        @if(is_null( old('member')))
                        <option value="" disabled selected>Selecteer een gebruiker...</option>
                        @else
                        <option value ="{{old('member')}}" selected>{{old('member')}}</option>
                        @endif
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
                    <select class="js-example-basic-single form-select @error('status') is-invalid @enderror" name="status" id="status" aria-label="Default select example">
                        @if(is_null( old('status')))
                        <option value="" disabled selected>Selecteer een status...</option>
                        @else
                        <option value ="{{old('status')}}" selected>{{old('status')}}</option>
                        @endif
                        @foreach ($statuses as $status)
                        <option value="{{$status->name}}">{{ $status->name }}</option>
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
                <a href="{{ route('admin.tasks.index') }}"><button type="button" class="btn mb-3">Ga terug</button></a>
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection