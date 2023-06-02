@extends('layouts.admin')
@section('content')
<div class="row ">
    <div class="col-6">
        <h1> Taken </h1>
    </div>
    <div class="col-4 text-end">
        <form action="{{ route('admin.tasks.search') }}">
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
        <a href="{{ route('admin.tasks.create') }}"><button class="btn btn-primary">Nieuwe taak</button></a>
    </div>
</div>

<div class="row card">
    <div class="col-12 ">
        <table class="table">
            <thead>
                <select class="form-select w-25 position-absolute top-0 end-0" onchange="location = this.value"
                        name="user" id="user" aria-label="Default select example">
                        <option value="/admin/tasks/completed">Afgeronde taken</option>
                        <option value="/admin/tasks/uncompleted">Open taken</option>
                        @if(isset($user))
                        <option value="/admin/tasks/">Alle gebruikers</option>
                        @endif
                        <option value="/admin/tasks/" selected>@if(isset($user)){{$user->name}}@elseif(isset($filter)){{$filter}}@else Alle gebruikers @endif</option> 
                        @foreach($users as $user)
                        <option value="/admin/tasks/user/{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
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
                            <td class="text-end"> 
                                @if($task->completed == 0)
                            
                                    <a href="{{ route('admin.tasks.complete', $task) }}"><button
                                        type="button" class="btn btn-link link-dark">
                                    <i class="fa fa-check"></i>
                                    </button></a>
                                @endif
                                @if($task->completed == 1)
                                <a href="{{ route('admin.tasks.uncomplete', $task) }}"><button
                                    type="button" class="btn btn-link link-dark">
                                <i class="fa fa-close"></i>
                                </button></a>
                                @endif
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
@endsection
