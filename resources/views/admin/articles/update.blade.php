    @extends('layouts.app')
    @section('content')
        <div class="row">
            <div class="col-12">
                <h1>Bewerk artikel</h1>
            </div>
        </div>
        @foreach($article as $article)
        <div class="row">
            <div class="col-12 card">
                <form method="post" name="articleform" action="/admin/articles/update">
                    <input value="{{$article->id}}"name="id" type="hidden"> 

                    <div class="row mb-3  mt-4">
                        <label for="title" class="col-md-4 col-form-label text-md-end">Titel:</label>
                        <div class="col-md-5">
                            <input value="{{$article->title}}" type="text" class="form-control" name="title" required autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="category" class="col-md-4 col-form-label text-md-end">Categorie:</label>
                        <div class="col-md-5">
                            <select class="form-select" name="category" id="category" aria-label="Default select example">
                                <option selected>{{$article->category}}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Afbeelding:</label>
                        <div class="col-md-5">
                                <input class="form-control" name="image" type="file" id="image">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Publiceer datum:</label>
                        <div class="col-md-5">
                            <input type="datetime-local" class="form-control" name="published_at" step="any"> 
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                        <div class="col-md-5">
                            <input value="{{$article->description}}" type="text" class="form-control" name="description" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="content" class="col-md-4 col-form-label text-md-end">Content:</label>
                        <div class="col-md-5">
                            <input value="{{$article->content}}" id="editor" type="text" class="form-control" name="content" required autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-5">
                            <img src="\images\{{$article->image}}">
                        </div>
                    </div>

                    <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4">
                        <button class="btn btn-primary mb-3">Submit</button>
                    </div>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
        @endforeach
    @endsection
    @section('scripts')
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
</div>
@endsection