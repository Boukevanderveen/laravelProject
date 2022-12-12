<!DOCTYPE html>
@include('auth.authcheck')
@include('header')

<head>
</head>
<body>
    <div class='dash'>Je bent ingelogt als: {{\Auth::user()->name}} ,  <a href="{{url('logout')}}"> uitloggen</a></div> 
    <br><br><br><br>
    <p id="mainTextDashboard"> Contactpersonen: </p>
    <div id="contactPersonsContainer">
    
        <!-- Haalt uit de friends table en filtert je eigen gebruikersnaam uit -->

        @foreach($records as $record)
        @if($record->friend1 !== $currentuser)
        <form onsubmit="sendCurrentName()" id="goToDmForm" action="/DM" method="post">
            <input class="contactPersonText" type="hidden" value={{$record->friend1}} name="receiver">

            <button type="submit" class="link-button">{{$record->friend1}}</button>
            {{ csrf_field() }}

        </form>

        @else
        <form id="goToDmForm2" action="/DM" method="post">
            <input type="hidden" value={{$record->friend2}} name="receiver">

            <button type="submit" class="link-button">{{$record->friend2}}</button>
            {{ csrf_field() }}

        </form>
        @endif
        @endforeach
    </div>
</body>
</html>