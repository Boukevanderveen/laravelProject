@extends('layouts.admin')
@section('content')

<div class="row ">
    <div class="col-6 mt-2">
        <h1> Rollen </h1>
    </div>
    <div class="col-4 text-end">
        <form action="{{ route('admin.roles.search') }}">
            <div class="input-group">
                <input @isset($search_term) value="{{$search_term}}" @endisset type="text" class="form-control" placeholder="Zoeken op naam" name="search_term" id="search_term">
                <div class="input-group-append">
                    <button class="btn" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-2 text-end">
        <a href="{{ route('admin.roles.create') }}"><button class="btn btn-primary">Nieuwe rol</button></a>
    </div>
</div>

<div class="row">
    <div class="col-12 card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Gemaakt op</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->created_at->format('d-m-Y') }}</td>

                        <form method="post" action="{{ route('admin.roles.destroy', $role) }}"> @csrf @method('delete')
                            <td class="text-end"><a href="{{ route('admin.roles.edit', $role) }}"><button type="button" btn btn-link
                                class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                        <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $role->name }} wilt verwijderen?')"
                                class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>  
                    	
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $roles->links() }}
    </div>    
</div>
@if(!$roles->isEmpty())
<div class="modal fade modal-lg" id="confirmdeletionmodal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Artikel verwijderen</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body">
            <div class="modal-body">
                Weet u zeker dat u deze rol wilt verwijderen?
               </div>
        </div>
  
        <div class="modal-footer">
            <form action="{{ route('admin.roles.destroy', $role) }}" method="get">@csrf<button type="submit" class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Toch verwijderen</button></form>
        </div>
  
      </div>
    </div>
  </div>
  @endif
@endsection
