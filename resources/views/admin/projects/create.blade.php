@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Creëer project</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="projectform" action="/admin/projects/create">
            <input type="hidden"> 

            <div class="row mb-3  mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                <div class="col-md-5">
                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                </div>
            </div>
            <div class="row mb-3">
                <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                <div class="col-md-5">
                    <input id="description" type="text" class="form-control" name="description" required autofocus>
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
@endsection