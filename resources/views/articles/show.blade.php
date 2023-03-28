@extends('layouts.app')
@section('content')
<h1>{{$article->title}}</h1>
{{$article->description}}
<br><br>
{!! $article->content !!}
<br>
Geschreven door: {{$article->author}}
<br>
Gepubliceerd op: {{$article->published_at}}
<br>
Categorie: {{$article->category}}



@endsection 