<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
$productCategories = \App\Models\ProductCategory::all();
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script type="text/javascript" src="js/bootstrap/bootstrap-dropdown.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    @include('includes.navbar')
    @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div> 
    @endif
    <div class="container">
        <div class="row">

            <div class="col-12">
                @include('includes.flashmessage')
                @include('includes.modals')
                @yield('content')
                @yield('scripts')
            </div>
        </div>
    </div>
</body>

</html>
