@include('navbar')
<div class="container">
@foreach ($article as $article)
    <h1>{{ $article->title }}</h1>
    <br><br><br>
    <h5>{{ $article->content }}</h5>
    <br><br>
    <h5>Geschreven door: {{ $article->author }}</h5>

    @can('update', $article)
        <a href="/articles/article/{{ $article->id }}/edit"><button class="btn btn-warning" type="submit">Bewerk artikel</button> </a>
    @endcan
    @can('delete', $article)
        <form method="POST" action="/articles/deletearticle">
            <input type="hidden" name="articleid" value={{ $article->id }}>
            <button class="btn btn-danger" type="submit">Verwijder artikel</button>
            @csrf
        </form>
        <a href="/home/articles"><button class="btn btn-secondary">Terug</button></a>
    @endcan
@endforeach
