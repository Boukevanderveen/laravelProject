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
        
        Nieuw artikel
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
        <form method="post" name="articleform" action="/articles/createarticle">
            <div class="form-group">
                <label for="inputTitle">Title</label>
                <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <input type="text" name="description" class="form-control" id="inputDescription"
                    placeholder="Enter description">
            </div>
            <div class="form-group">
                <label for="inputContent">Content</label>
                <input type="text" name="content" class="form-control" id="inputContent" placeholder="Enter content">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            @csrf
        </form>
        <a href="/home/articles"><button class="btn btn-secondary">Terug</button></a>
        </head>
    </body>
</html>
