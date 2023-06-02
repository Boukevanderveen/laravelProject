@extends('layouts.admin')
@section('content')
@yield('scripts')

<div class="row">
    <div class="col-12">

        <h1>Creëer artikel</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 card">
        <form method="post" name="articleform" action="/admin/articles/store" enctype="multipart/form-data">

            <div class="row mb-3 mt-5">
                <label for="title" class="col-md-4 col-form-label text-md-end">Titel:</label>
                <div class="col-md-5">
                    <input class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" type="text" id="title" name="title" autofocus>
                    @if ($errors->has('title'))
                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="category" class="col-md-4 col-form-label text-md-end">Categorie:</label>
                <div class="col-md-5">
                    <select class="form-select @error('category') is-invalid @enderror" name="category" id="category" aria-label="Default select example" autofocus>
                        <option selected>{{ old('category') }}</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category'))
                    <div class="invalid-feedback">{{ $errors->first('category') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="image" class="col-md-4 col-form-label text-md-end">Afbeelding:</label>
                <div class="col-md-5">
                        <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="image" autofocus>
                        @if ($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                        @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="published_at" class="col-md-4 col-form-label text-md-end">Publiceer datum:</label>
                <div class="col-md-5">
                    <input value="{{ old('published_at') }}" type="date" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" step="any" autofocus>
                    @if ($errors->has('published_at'))
                    <div class="invalid-feedback">{{ $errors->first('published_at') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                <div class="col-md-5">
                    <textarea rows="3" class="form-control @error('description') is-invalid @enderror" id="description" name="description"   autofocus>{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="content" class="col-md-4 col-form-label text-md-end">Content:</label>
                <div class="col-md-5">
                    <textarea id="editor5" type="text" class="form-control @error('content') is-invalid @enderror" name="content"   autofocus>{{old('content')}}</textarea>
                    @if ($errors->has('content'))
                    <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                    @endif
                </div>
            </div>

            <div class="row">
            <div class="col-7"></div>
            <div class="col-5">
                <a href="{{ route('admin.articles.index') }}"><button type="button" class="btn mb-3">Ga terug</button></a>
                <button class="btn btn-primary mb-3">Bevestig</button>
            </div>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection
@section('scripts')

<style>
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 200px;
    }

</style>
</div>
@endsection
