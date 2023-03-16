@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Bewerk categorie</h1>
        </div>
    </div>
    @foreach($category as $category)
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="categoryform" action="/admin/categories/update">
                <input value="{{$category->id}}"name="id" type="hidden"> 

                <div class="row mb-3  mt-4">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input value="{{old('name', $category->name)}}" id="name" type="text" class="form-control" name="name"   autofocus>
                    </div>
                </div>
                <div class="row">
                <div class="col-7"></div>
                <div class="col-5">
                    <a href="/admin/categories"><button type="button" class="btn btn-secondary mb-3">Ga terug</button></a>
                    <button class="btn btn-primary mb-3">Bevestig</button>
                </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
    @endforeach
@endsection
