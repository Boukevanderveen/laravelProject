@include('auth.authcheck')
@include('navbar')
@foreach ($article as $article)
<h1>{{$article->title}}</h1>
<br><br><br>
<h5>{{$article->content}}</h5>
<br><br>
<h5>Geschreven door: {{$article->author}}</h5>

@if(auth::check())
@if(Auth::user()->name == $article->author || Auth::user()->isAdmin == 0)
<a href="/article/{{$article->id}}/edit"><button type="submit">Bewerk artikel</button> </a>

    <form method="POST" action="/deletearticle">
        <input type="hidden" name="articleid" value={{$article->id}}>
        <button type="submit">Verwijder artikel</button>
        @csrf
    </form>
    @endif
@endif

@endforeach
