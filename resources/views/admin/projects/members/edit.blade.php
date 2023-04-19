@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Bewerk</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="projectmemberform" action="{{ route('admin.projects.members.membersupdate', [$project, $member]) }}">
            <input type="hidden" name="user" value="{{$member}}">
                <div class="row mb-3 mt-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Rol:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="role" id="role" aria-label="Default select example" autofocus>
                            <option selected></option>
                            @foreach ($roles as $role)

                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-3">
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
