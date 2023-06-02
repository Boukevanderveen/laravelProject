@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-6">
            <h1>Adressen</h1>
        </div>
        <div class="col-4">
            <form action="{{ route('admin.adresses.search') }}">
                <div class="input-group">
                    <input @isset($search_term) value="{{$search_term}}" @endisset type="text" class="form-control" placeholder="Zoeken op gebruiker" name="search_term" id="search_term">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-2 text-end">
            <a href="{{ route('admin.adresses.create') }}"><button class="btn btn-primary">Nieuw adres</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Gebruiker</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Straat</th>
                        <th scope="col">Huisnummer</th>
                        <th scope="col">Postcode</th>
                        <th scope="col">Woonplaats</th>
                        <th scope="col">Aangemaakt op</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adresses as $adress)
                        <tr>
                            <td>{{ $adress->id }}</td>
                            <td>{{ $adress->user->name }}</td>
                            <td>{{ $adress->name }}</td>
                            <td>{{ $adress->street}}</td>
                            <td>{{ $adress->house_number }}</td>
                            <td>{{ $adress->zipcode }}</td>
                            <td>{{ $adress->city }}</td>
                            <td>{{ $adress->created_at->format('d-m-Y') }}</td>
                            
                                <form method="post" action="{{ route('admin.adresses.destroy', $adress) }}"> @csrf @method('delete')
                                    <td class="text-end"><a href="{{ route('admin.adresses.edit', $adress) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je dit adres wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $adresses->links() }}
        </div>
    </div>
@endsection

