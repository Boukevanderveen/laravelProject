<!doctype html>
<html lang="en">
@include('navbar')
<div class="container">
<head>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    Bewerk Project Gegevens
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    @endif
    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/app.js"></script>

<body>
    @foreach ($project as $project)
        <form method="post" name="projectform" action="/projects/editproject">
            <input type="hidden" name="id" value="{{ $project->id }}">
            <div class="form-group">
                <label for="inputTitle">Naam</label>
                <input type="text" value="{{ $project->name }}" name="name" class="form-control" id="inputTitle"
                    placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <input type="text" value="{{ $project->description }}" name="description" class="form-control"
                    id="inputDescription" placeholder="Enter description">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            @csrf
        </form>
        <a href="/projects/project/{{ $project->id }}"><button class="btn btn-secondary">Annuleer</button></a>

    @endforeach
    </head>
</body>

</html>
