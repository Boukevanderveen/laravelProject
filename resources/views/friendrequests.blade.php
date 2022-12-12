<html>
    @include('auth.authcheck')
    @include('header')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>
    
    $('.item-nav').click(function (event) {
        // Avoid the link click from loading a new page
        event.preventDefault();
    
        // Load the content from the link's href attribute
        $('.content').load($(this).attr('href'));
    });
</script>
<body>

<div class="generalContainer">
    <div> 
    <p class="generalTextLarge"> Ingaande Vriendschapsverzoeken:</p> <br> <br> 
    @if($incomingFriendRequestsCount < 1)
    Nog geen verzoeken!
    @else

        @foreach($incomingFriendRequests as $incomingFriendRequest)
        <p class="generalTextMedium"> {{ $incomingFriendRequest->sender }} </p>
        <br>
        <form method="POST" action=/acceptfriendreq>
        <button>Accepteer </button>
        @csrf
        <input type = "hidden" name = "sender" value = {{$incomingFriendRequest->sender}} />
        <input type = "hidden" name = "receiver" value = {{$incomingFriendRequest->receiver}} />
        <input type = "hidden" name = "friendrequestid" value = {{$incomingFriendRequest->id}} />
        </form>
        <form action=declinefriendreq> 
        </form>
        <form method="POST" action=/declinefriendreq>
        <button>Weiger </button> 
        @csrf
        <input type = "hidden" name = "friendrequestid" value = {{$incomingFriendRequest->id}} />
        </form>

        @endforeach 
    @endif
    </div>

    <div>
    
        <br> 
        <p class="generalTextLarge"> Uitgaande Vriendschapsverzoeken:</p> <br> <br>
        @if($outgoingFriendRequestsCount < 1)
        Nog geen openstaande verzoeken!
        @else
    
            @foreach($outgoingFriendRequests as $outgoingFriendRequest)
            <p class="generalTextMedium">{{ $outgoingFriendRequest->receiver }} </p>
            <br>

            <form method="POST" action=/deletefriendreq>
            <button>Verwijder </button> 
            @csrf
            <input type = "hidden" name = "friendrequestid" value = {{$outgoingFriendRequest->id}} />
            </form>
    
            @endforeach 
        @endif

    </div>
</div>
</body>
</html>