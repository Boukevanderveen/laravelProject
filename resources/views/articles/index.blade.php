@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Artikelen</h1>
    </div>
</div>
<div class="row">

@foreach($articles as $article)
    <div class="col-4">
    <div class="card d-flex align-items-start">
        @if($article->image)
        <img class="card-img-top" height="250" src="images/articles/{{$article->image}}" alt="Card image cap">
        @else
        <img class="card-img-top" height="250" src="images/default-img.gif" alt="Card image cap">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{$article->title}}</h5>
            <p class="card-text">{{$article->description}}</p>

            <a href="{{ route('articles.show', $article) }}" class="btn btn-primary btn-m">Lees artikel</a>
        </div>
    </div>
</div>
@endforeach
</div>
@endsection