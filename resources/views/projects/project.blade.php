@include('users.authcheck')
@include('navbar')
<div class="container">
@foreach ($project as $project)
    <h1>{{ $project->name }}</h1>
    <br><br><br>
    <h5>{{ $project->description }}</h5>
    <br><br>
    <h5>Project eigenaar: {{ $project->creator }}</h5>
        @can('update', $project)
        <a href="/projects/project/{{ $project->id }}/edit"><button class="btn btn-warning" type="submit">Bewerk project gegevens</button> </a>
        @endcan
        @can('delete', $project)
        <form method="POST" action="/projects/deleteproject">
            <input type="hidden" name="id" value={{ $project->id }}>
            <button class="btn btn-danger" type="submit">Verwijder project</button>
            @csrf
        </form>
        @endcan
        <a href="/home/projects"><button class="btn btn-secondary">Terug</button></a>
@endforeach
