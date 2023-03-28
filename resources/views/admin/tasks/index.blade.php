@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-10">
        <h1> Taken </h1>
    </div>
    <div class="col-2">
        <a href="/admin/tasks/create"><button class="btn btn-secondary">Nieuwe taak</button></a>
    </div>
</div>

<div class="row">
    <div class="col-12 card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Project</th>
                    <th scope="col">Taak</th>
                    <th scope="col">Medewerker</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->deadline }}</td>
                        <td>{{ $task->project->name }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->member->name }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td> <a href="{{ route('admin.tasks.edit', $task) }}"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a><a href="{{ route('admin.tasks.destroy', $task) }}"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    
</div>
@endsection
