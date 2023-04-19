@extends('layouts.admin')
@section('content')
@include('includes.admin.projecttabs')

    <div class="row">
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                <div class="row mt-2">
                    <div class="col-12">
                        <h1> Project </h1>
                    </div>
                </div>
                <div class="col-12 card">
                    <form method="post" name="projectform" action="{{ route('admin.projects.update', $project) }}"> <!-- route('route', $model) -->
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
                            <div class="col-7"></div>
                            <div class="col-5">
                                <a href="/admin/projects"><button type="button" class="btn mb-3">Ga terug</button></a>
                                <button class="btn btn-primary mb-3">Bevestig</button>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>

    </div>
@endsection

