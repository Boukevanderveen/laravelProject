@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-12">

    </div>
</div>
<div class="row">
    <div class="col-12">
    @yield('scripts')

        <h1>Creëer artikel</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="articleform" action="/admin/articles/create" enctype="multipart/form-data">
            <div class="row mb-3 mt-5">
                <label for="title" class="col-md-4 col-form-label text-md-end">Titel:</label>
                <div class="col-md-5">
                    <input value="{{ old('title') }}" type="text" class="form-control" name="title">
                </div>
            </div>

            <div class="row mb-3">
                <label for="category" class="col-md-4 col-form-label text-md-end">Categorie:</label>
                <div class="col-md-5">
                    <select class="form-select" name="category" id="category" aria-label="Default select example"   autofocus>
                        <option selected>{{ old('category') }}</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="image" class="col-md-4 col-form-label text-md-end">Afbeelding:</label>
                <div class="col-md-5">
                        <input class="form-control" name="image" type="file" id="image">
                </div>
            </div>
            

            <div class="row mb-3">
                <label for="published_at" class="col-md-4 col-form-label text-md-end">Publiceer datum:</label>
                <div class="col-md-5">
                    <input value="{{ old('published_at') }}" type="datetime-local" class="form-control" name="published_at" step="any"> 
                </div>
            </div>

            <div class="row mb-3">
                <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                <div class="col-md-5">
                    <input value="{{ old('description') }}" type="text" class="form-control" name="description">
                </div>
            </div>
            
            <div class="row mb-3">

                <label for="content" class="col-md-4 col-form-label text-md-end">Content:</label>
                <div class="col-md-5">
                    <textarea id="editor3" type="text" class="form-control" name="content">{{ old('content') }}</textarea>
                </div>
            </div>

            <div class="row">
            <div class="col-7"></div>
            <div class="col-5">
                <a href="/admin/articles"><button type="button" class="btn btn-secondary mb-3">Ga terug</button></a>
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
        ClassicEditor
        .create( document.querySelector( '#editor2' ) )
        .catch( error => {
            console.error( error );
        } );
        ClassicEditor
        .create( document.querySelector( '#editor3' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
</div>
@endsection
