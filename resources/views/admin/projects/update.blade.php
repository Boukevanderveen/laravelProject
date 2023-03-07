@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Bewerk project</h1>
        </div>
    </div>
    @foreach($project as $project)
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="projectform" action="/admin/projects/update">
                <input value="{{$project->id}}"name="id" type="hidden"> 

                <div class="row mb-3  mt-4">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Titel:</label>
                    <div class="col-md-5">
                        <input value="{{$project->name}}" id="name" type="text" class="form-control" name="name" required autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                    <div class="col-md-5">
                        <input value="{{$project->description}}" id="description" type="text" class="form-control" name="description" required autofocus>
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
    @endforeach
@endsection
