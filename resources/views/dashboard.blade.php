
<!DOCTYPE html>
<html>
@include('navbar')
@include('auth.authcheck')
<div class='dash'>Je bent ingelogt als: {{\Auth::user()->name}},  <a href="{{url('logout')}}"> uitloggen</a></div> 
    <table>
    @if(!is_null($articles))
    @foreach ($articles as $article)
    <tbody>
        <tr>
            <td class="">
                {{ $article->title }}
                {{ $article->description }}
                {{ $article->author }}
                <a href="/article/{{$article->id}}"><button type="submit">Lees artikel</button> </a>
            </td>
        </tr>
    </tbody>
@endforeach
@endif
</table>
<head>
@if(Auth::Check())
@if(Auth::user()->isAdmin == 1)
<a href="/createarticleview">New Article</a> <br>
<a href="/manageusersview">Manage Users</a>
@endif
@endif
</head>
</html>