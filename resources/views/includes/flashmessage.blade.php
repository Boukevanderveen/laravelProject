@if(Session::has('message'))
<p class="alert alert-info">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
<p class="alert alert-danger">{{ Session::get('error') }}</p>
@endif
