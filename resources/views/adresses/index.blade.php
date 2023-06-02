@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-10">
        <h1>Mijn adressen</h1>
    </div>
   
    <div class="col-2 text-end">
        <a href="{{ route('adresses.create') }}"><button class="btn btn-primary">Nieuw adres</button></a>
    </div>
</div>
<div class="row">
@foreach($adresses as $adress)
<table id="cart" class="table table-hover table-condensed">
    <tbody>
    <div class="col card">
            <div class="row mt-2">
                <div class="col-10">
                    <h6>{{$adress->name}}</h6>
                    <h6>{{$adress->company}}</h6>

                    <h6>{{$adress->street}} {{$adress->house_number}}{{$adress->addition}}</h6>
                    <h6>{{$adress->zipcode}} {{$adress->city}}</h6>
                    <h6>{{$adress->phone_number}} {{$adress->email}}</h6>
                </div>
                <div class="col-1">
                    <a href="{{ route('adresses.edit', $adress) }}"><button type="button" btn btn-link
                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                        <form method="post" action="{{ route('adresses.destroy', $adress) }}"> @csrf @method('delete')
                            <button type="submit" onclick="return confirm('Weet je zeker dat je dit adress wilt verwijderen?')"
                                class="btn btn-link link-dark"><i class="fa fa-trash"></i></button>
                        </form>
                </div>

            </div>
        </div>
    </tbody>
    </div>
            
</table>
@endforeach

</div>
@endsection