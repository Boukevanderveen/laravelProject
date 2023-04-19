@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-10">
        <h1> Statusen </h1>
    </div>
    <div class="col-2 text-end">
        <a href="{{ route('admin.statuses.create') }}"><button class="btn btn-primary">Nieuwe status</button></a>
    </div>
</div>

<div class="row card">
    <div class="col-12">
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
                @foreach ($statuses as $status)
                    <tr>
                        <td>{{ $status->id }}</td>
                        <td>{{ $status->name }}</td>
                        <td>{{ $status->created_at->format('d-m-Y') }}</td>
                        <form method="post" action="{{ route('admin.statuses.destroy', $status) }}"> @csrf @method('delete')
                            <td class="text-end"><a href="{{ route('admin.statuses.edit', $status) }}"><button type="button" btn btn-link
                                class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                        <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $status->name }} wilt verwijderen?')"
                                class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>  
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $statuses->links() }}
    </div>    
</div>

@if(!$statuses->isEmpty())
<div class="modal fade modal-lg" id="confirmdeletionmodal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Artikel verwijderen</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body">
            <div class="modal-body">
                Weet u zeker dat u deze status wilt verwijderen?
               </div>
        </div>
  
        <div class="modal-footer">
            <form action="{{ route('admin.statuses.destroy', $status) }}" method="get">@csrf<button type="submit" class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Toch verwijderen</button></form>
        </div>
  
      </div>
    </div>
  </div>
  @endif
@endsection
