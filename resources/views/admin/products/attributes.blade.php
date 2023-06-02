@extends('layouts.admin')
@section('content')
    <div class="row mt-2">
        <div class="col-12">
            <h1>Attributen</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @include('includes.admin.producttabs')
        </div>
    </div>
    <div class="row">
        @if(!isset($product->type->attributes))
        <h5>Er zijn geen attributen voor dit product. Controleer of dit product een type heeft en of het type wel attributen heeft.</h5>
        @else
        <div class="col-12 card">
            <form class="mt-5" method="post" name="productform" action="{{ route('admin.products.attributes.update', $product ) }}" enctype="multipart/form-data">

                @foreach($product->type->attributes as $attribute)

                <div class="row mb-3">
                    <label for="{{$attribute->name}}" class="col-md-4 col-form-label text-md-end">{{$attribute->name}}:</label>
                    <div class="col-md-5">
                        <input class="form-control @error('attributeValues.'.$attribute->id) is-invalid @enderror" value="{{ old('attributeValues')[$attribute->id] ?? "" }}" type="text" id="{{$attribute->id}}" name="attributeValues[{{$attribute->id}}]" autofocus>
                        @if ($errors->has('attributeValues.'.$attribute->id))
                        <div class="invalid-feedback">{{ $errors->first('attributeValues.'.$attribute->id) }}</div>
                        @endif
                    </div>
                </div>
                @if(null == old('attributeValues'))
                @foreach($attribute->values->where('product_id', $product->id) as $value)
                @php
                echo '<script type="text/javascript">
                ',
                'document.getElementById('.$value->attribute_id.').value = "'.$value->value.'";',
                '
                </script>';
                @endphp
            
               
                @endforeach
                @endif

                @endforeach
                
                <div class="row">
                <div class="col-7"></div>
                <div class="col-5">
                    <a href="{{ route('admin.products.index') }}"><button type="button" class="btn mb-3">Ga terug</button></a>
                    <button class="btn btn-primary mb-3">Bevestig</button>
                </div>
                </div>
                @csrf
            </form>
        </div>
        @endif

    </div>
@endsection
