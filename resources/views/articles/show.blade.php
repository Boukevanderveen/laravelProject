@extends('layouts.app')
@section('content')

<h1>{{$article->title}}</h1>
<br>
Geschreven door: {{$article->author}}
<br>
Gepubliceerd op: {{ date('d-m-Y', strtotime($article->published_at)) }}
<br>
{{$article->description}}
<br><br>
{!! $article->content !!}
<br>

<br>
Categorie: {{$article->category}}
<br>
<a href="{{ route('articles.index') }}"><button type="button" class="btn btn-primary mb-3">Ga terug</button></a>
@endsection 