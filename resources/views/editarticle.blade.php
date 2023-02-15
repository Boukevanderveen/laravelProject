<!doctype html>
<html lang="en">
@include('navbar')

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

    Bewerk artikel
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
    @foreach ($article as $article)
        @if (Auth::user()->can('update', $article))
            <form method="post" name="articleform" action="/editarticle">
                <input type="hidden"name="id" value="{{ $article->id }}">
                <div class="form-group">
                    <label for="inputTitle">Title</label>
                    <input type="text" value="{{ $article->title }}" name="title" class="form-control"
                        id="inputTitle" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="inputDescription">Description</label>
                    <input type="text" value="{{ $article->description }}" name="description" class="form-control"
                        id="inputDescription" placeholder="Enter description">
                </div>
                <div class="form-group">
                    <label for="inputContent">Content</label>
                    <input type="text" value="{{ $article->content }}" name="content" class="form-control"
                        id="inputContent" placeholder="Enter content">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                @csrf
            </form>
        @else
            <script>
                window.location.href = "/";
            </script>
        @endif
    @endforeach
    </head>
</body>

</html>
