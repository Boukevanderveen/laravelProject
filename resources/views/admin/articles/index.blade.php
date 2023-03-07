@extends('layouts.app')
@section('content')

    <script type="text/javascript" src="js/bootstrap/bootstrap-dropdown.js"></script>
    <div class="row">
        <div class="col-10">
            <h1>Artikelen</h1>
        </div>
        <div class="col-2">
            <a href="/admin/articles/create"><button class="btn btn-secondary">Nieuw artikel</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <table class="table">
                <thead>
                    <select class="form-select w-25 position-absolute top-0 end-0" onchange="location = this.value"
                        name="category" id="category" aria-label="Default select example">
                        <option value="/admin/articles/">Alle artikelen</option>
                        @foreach($categories as $category)
                        <option value="/admin/articles/category/{{$category->name}}">{{$category->name}}</option>
                    @endforeach
                    </select>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titel</th>
                        <th scope="col">Beschrijving</th>
                        <th scope="col">Auteur</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->description }}</td>
                            <td>{{ $article->author }}</td>
                            <td><a href="/admin/articles/{{ $article->id }}/update"><button btn btn-link
                                        class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a> <a
                                    href="/admin/articles/{{ $article->id }}/delete"><button
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $articles->links() }}
        </div>
    </div>
@endsection
