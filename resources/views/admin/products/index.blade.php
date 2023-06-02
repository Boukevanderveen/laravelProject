@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-6">
            <h1>Producten</h1>
        </div>
        <div class="col-4 text-end">
            <form action="{{ route('admin.products.search') }}">
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
        <div class="col-2 text-end">
            <a href="{{ route('admin.products.create') }}"><button class="btn btn-primary">Nieuw product</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Prijs</th>
                        <th scope="col">Kortingsprijs</th>
                        <th scope="col">Voorraad</th>
                        <th scope="col">Categorieën</th>
                        <th scope="col">Type</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>€ {{str_replace('.', ',', $product->price)}}</td>
                            @if(isset($product->discount_price))
                            <td>€ {{str_replace('.', ',', $product->discount_price)}}</td>
                            @else
                            <td>Geen</td>
                            @endif
                            <td>{{ $product->stock }}</td>
                            <td>
                            @foreach($product->categories as $category)
                            {{ $category->name }},
                            @endforeach
                            </td>
                            @if(isset($product->type))
                            <td>{{ $product->type->name }}</td>
                            @else
                            <td>Geen</td>
                            @endif

                                <form method="post" action="{{ route('admin.products.destroy', $product) }}"> @csrf @method('delete')
                                    <td class="text-end"><a href="{{ route('admin.products.edit', $product) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $product->name }} wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
@endsection

