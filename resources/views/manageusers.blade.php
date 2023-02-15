<!DOCTYPE html>
<html>
@include('navbar')

    <table>
    @foreach ($users as $user)
    @if (Auth::user()->can('update', $user))
    <tbody>
        <tr>
                {{ $user->name }}
                @if($user->isAdmin == 1 && $user->isOwner == 0 && $user->name !== Auth::user()->name)
                <form method="POST" action="/removeadmin">
                    <input type="hidden" name="id" value={{$user->id}}>
                    <button type="submit">Verwijder admin privileges</button>
                    @csrf
                </form>
                @endif
                @if($user->isAdmin == 0 && $user->isOwner == 0)
                <form method="POST" action="/makeadmin">
                    <input type="hidden" name="id" value={{$user->id}}>
                    <button type="submit">Geef admin privileges</button>
                    @csrf
                </form>
                @endif
        </tr>
        <br>
    </tbody>
    @else
    <script>
        window.location.href = "/";
    </script>
@endif
@endforeach
</table>
<head>
</head>
</html>