@extends('layouts.admin')
@section('content')

<div class="row ">
    <div class="col-10">
        <h1> Taken </h1>
    </div>
    <div class="col-2 text-end">
        <a href="{{ route('admin.tasks.create') }}"><button class="btn btn-primary">Nieuwe taak</button></a>
    </div>
</div>

<div class="row card">
    <div class="col-12 ">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Project</th>
                    <th scope="col">Taak</th>
                    <th scope="col">Medewerker</th>
                    <th scope="col">Status</th>
                    <th scope="col">Gemaakt op</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->deadline->format('d-m-Y') }}</td>
                        <td>{{ $task->project->name }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->member->name }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td>{{ $task->created_at->format('d-m-Y') }}</td>
                        <!--/*<td> $task->status->name </td>*/-->
                        <form method="post" action="{{ route('admin.tasks.destroy', $task) }}"> @csrf @method('delete')
                            <td class="text-end"> <a href="{{ route('admin.tasks.complete', $task) }}"><button
                                class="btn btn-link link-dark">
                            <i class="fa fa-check"></i>
                            </button></a>
                            <a href="{{ route('admin.tasks.edit', $task) }}"><button type="button" btn btn-link
                                class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                        <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $task->name }} wilt verwijderen?')"
                                class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>  

                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    </div>    
</div>

@if(!$tasks->isEmpty())
<div class="modal fade modal-lg" id="confirmdeletionmodal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">Artikel verwijderen</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body">
            <div class="modal-body">
                Weet u zeker dat u deze taak wilt verwijderen?
               </div>
        </div>
  
        <div class="modal-footer">
            <form action="{{ route('admin.tasks.destroy', $task) }}" method="get">@csrf<button type="submit" class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Toch verwijderen</button></form>
        </div>
  
      </div>
    </div>
  </div>
  @endif
@endsection
