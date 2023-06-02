@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-6">
        <h1> Statusen </h1>
    </div>
    <div class="col-4 text-end">
        <form action="{{ route('admin.statuses.search') }}">
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
        <a href="{{ route('admin.statuses.create') }}"><button class="btn btn-primary">Nieuwe status</button></a>
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
                @foreach ($statuses as $status)
                    <tr>
                        <td>{{ $status->id }}</td>
                        <td>{{ $status->name }}</td>
                        <td>{{ $status->created_at->format('d-m-Y') }}</td>
                        <form method="post" action="{{ route('admin.statuses.destroy', $status) }}"> @csrf @method('delete')
                            <td class="text-end"><a href="{{ route('admin.statuses.edit', $status) }}"><button type="button" btn btn-link
                                class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                        <button type="submit" onclick="return confirm('Weet je zeker dat je {{ $status->name }} wilt verwijderen?')"
                                class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></td></form>  
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $statuses->links() }}
    </div>    
</div>
@endsection
