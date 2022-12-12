<link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />

<div id="mainHeader">
    <a id="navBarLogo" href="/">Messenger </a>
    <a id="navBarUrl1" href="/friendrequests">Vriendschapsverzoeken </a>
    <a id="navBarUrl2" href="/sendfriendrequest">Stuur vriendschapsverzoek </a>
    <a id="navBarUrl3" href="/logout">{{\Auth::user()->name}}:         Log uit </a>
    
    </div>