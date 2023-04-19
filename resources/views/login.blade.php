@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            @yield('scripts')
            <h1>Login</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="postform" action="/login">

                <div class="row mb-3 mt-5">
                    <label for="email" class="col-md-4 col-form-label text-md-end">E-mail:</label>
                    <div class="col-md-5">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control"
                              autofocus />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end"   autofocus>Wachtwoord:</label>
                    <div class="col-md-5">
                        <input type="password" id="password" name="password" class="form-control" />
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
