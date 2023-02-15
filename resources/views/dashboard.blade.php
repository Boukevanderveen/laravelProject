<!DOCTYPE html>
<html>
@include('auth.authcheck')
@include('navbar')
@if(Auth::Check())
<div class='dash'>Je bent ingelogt als: {{ Auth::user()->name }}, <a href="{{ url('logout') }}"> uitloggen</a></div>
@endif
<table>
    @if (!is_null($articles))
        @foreach ($articles as $article)
            <tbody>
                <tr>
                    <td class="">
                        {{ $article->title }}
                        {{ $article->description }}
                        {{ $article->author }}
                        <a href="/article/{{ $article->id }}"><button type="submit">Lees artikel</button> </a>
                    </td>
                </tr>
            </tbody>
        @endforeach
    @endif
</table>

<head>
    @can('create', $article)
        <a href="/createarticle">New Article</a> <br>
    @endcan
    
    @can('manageUsers', $article)
        <a href="/manageusersview">Manage Users</a>
    @endcan
</head>

</html>
