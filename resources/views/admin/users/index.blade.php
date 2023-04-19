@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-10">
            <h1> Gebruikers </h1>
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
        <div class="modal fade modal-lg" id="confirmdeletionmodal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
          
                <div class="modal-header">
                  <h4 class="modal-title">Artikel verwijderen</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
          
                <div class="modal-body">
                    <div class="modal-body">
                        Weet u zeker dat u deze gebruiker wilt verwijderen?
                       </div>
                </div>
          
                <div class="modal-footer">
                    <form action="{{ route('admin.users.destroy', $user) }}" method="get">@csrf<button type="submit" class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Toch verwijderen</button></form>
                </div>
          
              </div>
            </div>
          </div>
    </div>
@endsection
