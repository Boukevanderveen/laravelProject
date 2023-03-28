@extends('layouts.admin')
@section('content')

    <script type="text/javascript" src="js/bootstrap/bootstrap-dropdown.js"></script>
    <div class="row">
        <div class="col-10">
            <h1>Categorieën</h1>
        </div>
        <div class="col-2">
            <a href="/admin/categories/create"><button class="btn btn-secondary">Nieuwe categorie</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Categorie</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td><a href="{{ route('admin.categories.edit', $category) }}"><button class="btn btn-link link-dark"><i class="fa fa-pencil"></i></button></a><a href="{{ route('admin.categories.destroy', $category) }}"><button class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
@endsection
