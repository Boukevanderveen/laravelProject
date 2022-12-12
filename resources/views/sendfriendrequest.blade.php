<html>
    @include('auth.authcheck')
    @include('header')
    <form class="form" action="/sendfriendrequestdata" method="post">
        @csrf
        <h1>Voeg vriend toe</h1>
        <input type="text" name="receiver" placeholder="username" required />
        <input type = "hidden" name = "sender" value = {{\Auth::user()->name}} />
        <input type="submit" name="submit" value="Stuur vriendschapverzoek">
    </form>
</html>