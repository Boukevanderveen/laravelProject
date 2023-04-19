@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Bewerk artikel</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="articleform" action="{{ route('admin.articles.update') }}" enctype="multipart/form-data">
                <input value="{{$article->id}}"name="id" type="hidden"> 

                <div class="row mb-3  mt-4">
                    <label for="title" class="col-md-4 col-form-label text-md-end">Titel:</label>
                    <div class="col-md-5">
                        <input value="{{old('title', $article->title)}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title"   autofocus>
                        @if ($errors->has('title'))
                        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="category" class="col-md-4 col-form-label text-md-end">Categorie:</label>
                    <div class="col-md-5">
                        <select class="form-select @error('category') is-invalid @enderror" name="category" id="category" aria-label="Default select example">
                            <option selected>{{$article->category}}</option>
                            @foreach ($categories as $category)
                            <option value="{{old('category', $category->name)}}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category'))
                        <div class="invalid-feedback">{{ $errors->first('category') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Afbeelding:</label>
                    <div class="col-md-5">
                            <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="image">
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Publiceer datum:</label>
                    <div class="col-md-5">
                        <input value="{{old('published_at', $article->published_at)}}" type="date" class="form-control @error('published_at') is-invalid @enderror" name="published_at" step="any"> 
                        @if ($errors->has('published_at'))
                        <div class="invalid-feedback">{{ $errors->first('published_at') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                    <div class="col-md-5">
                        <input value="{{old('description', $article->description)}}" type="text" class="form-control @error('description') is-invalid @enderror" name="description"   autofocus>
                        @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="content" class="col-md-4 col-form-label text-md-end">Content:</label>
                    <div class="col-md-5">
                        <textarea value="{{$article->content}}" id="editor" type="text" class="form-control @error('content') is-invalid @enderror" name="content"   autofocus>{{old('content', $article->content)}}</textarea>
                        @if ($errors->has('content'))
                        <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-5">
                        <img src="\images\articles{{$article->image}}">
                    </div>
                </div>

                <div class="row">
                <div class="col-7"></div>
                <div class="col-5">
                    <a href="{{ route('articles') }}"><button type="button" class="btn mb-3">Ga terug</button></a>
                    <button class="btn btn-primary mb-3">Bevestig</button>
                </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
@section('scripts')
</div>
@endsection