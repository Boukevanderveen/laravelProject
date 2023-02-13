<!DOCTYPE html>
@include('auth.authcheck')

<head>
</head>
<body>
    <div class='dash'>Je bent ingelogt als: {{\Auth::user()->name}},  <a href="{{url('logout')}}"> uitloggen</a></div> 
    TWEEDE PAGINA
    </div>
</body>
</html>