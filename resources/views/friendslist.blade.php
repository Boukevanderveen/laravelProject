<html>
    @include('auth.authcheck')

<body>


    
    @if($friendscount < 1)         
        <p> Blijkbaar heb je geen vrienden </p>
    @else
    
        @foreach($records as $record)
        @if($record->friend1 !== $currentuser)
        {{$record->friend1}}
        @else
        {{$record->friend2}}
        @endif
        @endforeach
        <br>
    @endif
</body>
</html>