@extends('layouts.admin')
@section('content')

    <script type="text/javascript" src="js/bootstrap/bootstrap-dropdown.js"></script>
    <div class="row">
        <div class="col-6">
            <h1>Product types</h1>
        </div>
        <div class="col-3 text-end">
            <form action="{{ route('admin.types.search') }}">
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
            <a href="{{ route('admin.types.create') }}"><button class="btn btn-primary">Nieuwe product type</button></a>
        </div>
    </div>
    <div class="row card">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Attributen</th>
                        <th scope="col">Gemaakt op</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($types as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->name }}</td>
                            <td>
                                @foreach($type->attributes as $attribute)
                                {{$attribute->name}}, 
                                @endforeach
                            </td>
                            <td>{{ $type->created_at->format('d-m-Y') }}</td>

                                <form method="post" action="{{ route('admin.types.destroy', $type) }}"> @csrf @method('delete')
                                    <td class="text-end"><a href="{{ route('admin.types.edit', $type) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $type->name }} wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $types->links() }}
        </div>
    </div>
@endsection
