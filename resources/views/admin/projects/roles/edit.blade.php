@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col-12">
            <h1>Bewerk rol</h1>
        </div>
    </div>
@include('includes.admin.projecttabs')
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="projectrolesform" action="{{ route('admin.projects.roles.update', [$project, $role]) }}">
                <input value="{{$role->id}}"name="id" type="hidden"> 

                <div class="row mb-3  mt-4">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input value="{{old('name', $role->name)}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autofocus>
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
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
@endsection
