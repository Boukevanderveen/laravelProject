<!DOCTYPE html>
@include('auth.authcheck')
@include('header')
<html>
<head>
  <title></title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script> 

  <script>

    var currentuserint = {!! json_encode($dmId) !!};
    var currentuser = currentuserint.toString();

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('eb2c85711f7976c436fc', {
      cluster: 'eu',
      forceTLS: true
    });

    var channel = pusher.subscribe(currentuser);
    channel.bind('form-submitted', function(data) 
    {
      //alert(JSON.stringify(data));
      //$('#messagescontainer').load(document.URL +  ' #messagescontainer');
      //document.location.reload(true);
      $("#messagescontainer").load(window.location.href + " #messagescontainer" );
    });
  </script>

</head>
<body>

  <form id="messageForm" target="frame" action="/sender" method="post"> 
    <input id="messageField" type="text" name="message">
    <input type="hidden" value={{$currentuser}} name="sender">
    <input type="hidden" value={{$targetuser}} name="receiver">
    <input type="hidden" value={{$dmId}} name="dmid">
    <input type="submit">
    {{ csrf_field() }}
    </form>

</body>

<div id="messagescontainer">

@php
$verticalPositionCounter = 10;
@endphp

@foreach($messages as $message)
@if($message->sender !== $currentuser)
<div>
<p style="position: absolute; left: 10%; top: {{$verticalPositionCounter}}%">{{$message->sender}}: {{$message->message}} </p>
</div>

@php
$verticalPositionCounter += 4;
@endphp
@elseif($message->sender == $currentuser)
<div>
  <p style="position: absolute; left: 10%; top: {{$verticalPositionCounter}}%">{{$message->sender}}: {{$message->message}} </p>
  </div>  

@php
$verticalPositionCounter += 4;
@endphp

@endif
@endforeach

</div>

<!-- Preventeerd herladen van het scherm bij post -->
<iframe style="position: absolute; width:0; height:0; border:0;" name="frame"></iframe>

</html>

<script>
  function clearForm()
  {
    $("#messageForm")[0].reset();
  }
  </script>