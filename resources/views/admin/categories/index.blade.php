@extends('layouts.admin')
@section('content')

    <script type="text/javascript" src="js/bootstrap/bootstrap-dropdown.js"></script>
    <div class="row">
        <div class="col-6">
            <h1>Categorieën</h1>
        </div>
        <div class="col-4 text-end">
            <form action="{{ route('admin.categories.search') }}">
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
            <a href="{{ route('admin.categories.create') }}"><button class="btn btn-primary">Nieuwe categorie</button></a>
        </div>
    </div>
    <div class="row card">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Categorie</th>
                        <th scope="col">Gemaakt op</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at->format('d-m-Y') }}</td>

                                <form method="post" action="{{ route('admin.categories.destroy', $category) }}"> @csrf @method('delete')
                                    <td class="text-end"><a href="{{ route('admin.categories.edit', $category) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $category->name }} wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
@if(!$categories->isEmpty())
    <div class="modal fade modal-lg" id="confirmdeletionmodal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
      
            <div class="modal-header">
              <h4 class="modal-title">Artikel verwijderen</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
      
            <div class="modal-body">
                <div class="modal-body">
                    Weet u zeker dat u deze categorie wilt verwijderen?
                   </div>
            </div>
      
            <div class="modal-footer">
                <form action="{{ route('admin.categories.destroy', $category) }}" method="get">@csrf<button type="submit" class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Toch verwijderen</button></form>
            </div>
      
          </div>
        </div>
      </div>
      @endif
@endsection
