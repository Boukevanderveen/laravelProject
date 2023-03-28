@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Bewerk</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="projectmemberform" action="update">
                <input value="{{ $member->id }}"name="memberid" type="hidden">
                <input value="{{ $project->id }}"name="projectid" type="hidden">

                <div class="row mb-3 mt-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Rol:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="role" id="role" aria-label="Default select example" autofocus>
                            <option selected></option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
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
        </div>
    </div>
    @csrf
    </form>
    </div>
    </div>
@endsection
