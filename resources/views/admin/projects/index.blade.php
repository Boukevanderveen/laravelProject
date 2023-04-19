@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-10">
        <h1> Projecten </h1>
    </div>
    <div class="col-2 text-end">
        <a href="{{ route('admin.projects.create') }}"><button class="btn btn-primary">Nieuw project</button></a>
    </div>
</div>

<div class="row">
    <div class="card">
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
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->created_at->format('d-m-Y')}}</td>
                        
                        <form method="post" action="{{ route('admin.projects.destroy', $project) }}"> @csrf @method('delete')
                            <td class="text-end"><a href="{{ route('admin.projects.edit', $project) }}"><button type="button" btn btn-link
                                class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                        <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $project->name }} wilt verwijderen?')"
                                class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>

                    </tr>
                @endforeach
            </tbody>

        </table>
        {{ $projects->links() }}

    </div>    
</div>
@isset($roles)
<div class="modal fade modal-lg" id="confirmdeletionmodal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Artikel verwijderen</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body">
            <div class="modal-body">
                Weet u zeker dat u dit project wilt verwijderen?
               </div>
        </div>
  
        <div class="modal-footer">
            <form action="{{ route('admin.projects.destroy', $project) }}" method="get">@csrf<button type="submit" class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Toch verwijderen</button></form>
        </div>
  
      </div>
    </div>
  </div>
  @endisset
@endsection
