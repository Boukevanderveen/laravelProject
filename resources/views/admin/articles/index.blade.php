@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-6">
            <h1>Artikelen</h1>
        </div>
        <div class="col-4">
            <form action="{{ route('admin.articles.search') }}">
                <div class="input-group">
                    <input @isset($search_term) value="{{$search_term}}" @endisset type="text" class="form-control" placeholder="Zoeken" name="search_term" id="search_term">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-2 text-end">
            <a href="{{ route('admin.articles.create') }}"><button class="btn btn-primary">Nieuw artikel</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <table class="table">
                <thead>

                    <select class="form-select w-25 position-absolute top-0 end-0" onchange="location = this.value"
                        name="category" id="category" aria-label="Default select example">
                        @if(isset($category))
                        <option value="/admin/articles/">Alle artikelen</option>
                        @endif
                        <option value="/admin/articles/" selected>@if(isset($category)){{$category}}@else Alle artikelen @endif</option> 
                        @foreach($categories as $category)
                        <option value="/admin/articles/category/{{$category->name}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titel</th>
                        <th scope="col">Geschreven op</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Categorie</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->created_at->format('d-m-Y')}}</td>
                            <td>{{ $article->author }}</td>
                            <td>{{ $article->category }}</td>
                            
                                <form method="post" action="{{ route('admin.articles.destroy', $article) }}"> @csrf @method('delete')
                                    <td class="text-end"><a href="{{ route('admin.articles.edit', $article) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $article->title }} wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $articles->links() }}
        </div>
    </div>
@endsection

