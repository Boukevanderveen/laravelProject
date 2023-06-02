@extends('layouts.admin')
@section('content')

    <script type="text/javascript" src="js/bootstrap/bootstrap-dropdown.js"></script>
    <div class="row">
        <div class="col-6">
            <h1>Attributen</h1>
        </div>
        <div class="col-3 text-end">
            <form action="{{ route('admin.attributes.search') }}">
                <div class="input-group">
                    <input @isset($search_term) value="{{$search_term}}" @endisset type="text" class="form-control" placeholder="Zoeken op naam" name="search_term" id="search_term">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-3 text-end">
            <a href="{{ route('admin.attributes.create') }}"><button class="btn btn-primary">Nieuw attribuut</button></a>
        </div>
    </div>
    <div class="row card">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Gemaakt op</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attributes as $attribute)
                        <tr>
                            <td>{{ $attribute->id }}</td>
                            <td>{{ $attribute->name }}</td>
                            <td>{{ $attribute->created_at->format('d-m-Y') }}</td>

                                <form method="post" action="{{ route('admin.attributes.destroy', $attribute) }}"> @csrf @method('delete')
                                    <td class="text-end"><a href="{{ route('admin.attributes.edit', $attribute) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $attribute->name }} en alle bij horende waarden binnen alle producten wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $attributes->links() }}
        </div>
    </div>
@endsection
