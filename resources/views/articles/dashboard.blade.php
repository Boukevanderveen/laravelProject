<!DOCTYPE html>
<html>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@include('users.authcheck')
@include('navbar')
@if (Auth::Check())
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
                        <a href="/articles/article/{{ $article->id }}"><button type="submit">Lees artikel</button> </a>
                    </td>
                </tr>
            </tbody>
        @endforeach
    @endif
</table>
gtrfe
<head>
    @can('create', $article)
        <a href="articles/createarticle">New Article</a> <br>
    @endcan

    @can('manageUsers', $article)
        <a href="/users/manageusersview">Manage Users</a>
    @endcan
</head>

</html>
