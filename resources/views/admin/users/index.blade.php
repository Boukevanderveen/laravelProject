@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-6">
            <h1> Gebruikers </h1>
        </div>
        <div class="col-4 text-end">
            <form action="{{ route('admin.users.search') }}">
                <div class="input-group">
                    <input @isset($search_term) value="{{$search_term}}" @endisset type="text" class="form-control" placeholder="Zoeken" name="search_term" id="search_term">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-2 text-end">
            <a href="{{ route('admin.users.create') }}"><button class="btn btn-primary">Nieuwe gebruiker</button></a>
        </div>

        <div class="row">
            <div class="col-12 card">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Naam</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Gemaakt op</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        @if(Auth::user()->name != $user->name)

                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                <form method="post" action="{{ route('admin.users.destroy', $user) }}"> @csrf @method('delete')
                                    <td class="text-end"><a href="{{ route('admin.users.edit', $user) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $user->name }} wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>  
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
        {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
