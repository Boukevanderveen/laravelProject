@extends('layouts.admin')
@section('content')
    @yield('scripts')
    <div class="row">
        <div class="col-12">

            <h1>Creëer product</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <form method="post" name="productform" action="{{ route('admin.products.store') }}"  onsubmit="doSubmit()" enctype="multipart/form-data">

                <div class="row mb-3 mt-5">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Naam:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            type="text" id="name" name="name" autofocus>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="categories[]" class="col-md-4 col-form-label text-md-end">Categorieën:</label>
                    <div class="col-md-5">
                        <select class="js-example-basic-multiple" id="categories[]" name="categories[]" multiple="multiple">
                            @if(null !== old('categories'))
                            @foreach(old('categories') as $categoryid)
                            <option  selected value="{{ $categoryid }}">{{ \App\Models\ProductCategory::find($categoryid)->name }}</option>
                            @endforeach
                            @else
                            
                            @endif
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category'))
                        <div class="invalid-feedback">{{ $errors->first('category') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="typeid" class="col-md-4 col-form-label text-md-end">Type:</label>
                    <div class="col-md-5">
                        <select class="form-select" name="typeid" id="typeid" aria-label="Default select example"   autofocus>
                            <option value="">Geen</option>
                            @foreach ($types as $type)
                            <option @if(old('typeid') == $type->id) selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="picture" class="col-md-4 col-form-label text-md-end">Afbeelding:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('picture') is-invalid @enderror" name="picture" type="file"
                            id="picture" autofocus>
                        @if ($errors->has('picture'))
                            <div class="invalid-feedback">{{ $errors->first('picture') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="price" class="col-md-4 col-form-label text-md-end">Prijs: €</label>
                    <div class="col-md-5">
                        <input class="form-control @error('price') is-invalid @enderror" value="{{str_replace('.', ',', old('price')) }}"
                            type="text" id="price" name="price" autofocus>
                        @if ($errors->has('price'))
                            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="discount_price" class="col-md-4 col-form-label text-md-end">Kortingsprijs: €</label>
                    <div class="col-md-5">
                        <input class="form-control @error('discount_price') is-invalid @enderror"
                            value="{{str_replace('.', ',', old('discount_price')) }}" type="text" id="discount_price" name="discount_price" autofocus>
                        @if ($errors->has('discount_price'))
                            <div class="invalid-feedback">{{ $errors->first('discount_price') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="stock" class="col-md-4 col-form-label text-md-end">Voorraad:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}"
                            type="text" id="stock" name="stock" autofocus>
                        @if ($errors->has('stock'))
                            <div class="invalid-feedback">{{ $errors->first('stock') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="vat" class="col-md-4 col-form-label text-md-end">BTW:</label>
                    <div class="col-md-5">
                        <select class="form-select @error('vat') is-invalid @enderror" name="vat" id="vat"
                            aria-label="Default select example" autofocus>
                            @if(null !== old('vat'))
                            @if(old('vat') == 21)
                            <option value="21" selected>21%</option>
                            <option value="9">9%</option>
                            @endif
                            @if(old('vat') == 9)
                            <option value="9" selected>9%</option>
                            <option value="21">21%</option>
                            @endif
                            @else
                            <option value="21">21%</option>
                            <option value="9">9%</option>
                            @endif
                        </select>
                        @if ($errors->has('vat'))
                            <div class="invalid-feedback">{{ $errors->first('vat') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">Beschrijving:</label>
                    <div class="col-md-5">
                        <textarea id="editor4" class="form-control @error('description') is-invalid @enderror" id="description" name="description" autofocus>{{old('description')}}</textarea>
                        @if ($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <a href="{{ route('admin.products.index') }}"><button type="button" class="btn mb-3">Ga
                                terug</button></a>
                        <button class="btn btn-primary mb-3">Bevestig</button>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>

    <script>
    function doSubmit(){
    var price = document.getElementById('price').value.replace(",",".");
    var discount_price = document.getElementById('discount_price').value.replace(",",".");

    document.getElementById('price').value = document.getElementById('price').value.replace(",",".");
    document.getElementById('discount_price').value = document.getElementById('discount_price').value.replace(",",".");
    }
$(document).ready(function() {
        $('.js-example-basic-multiple').select2();
        $(".js-example-basic-multiple").select2({ width: '100%' });      

    });

        ClassicEditor
    .create( document.querySelector( '#editor4' ) )
    .catch( error => {
        console.error( error );
    } );
    </script>
    <style>
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 200px;
    }
    </style>
@endsection
