<!DOCTYPE html>
<html>
@include('users.authcheck')
@include('navbar')
@if(Auth::Check())
<div class='dash'>Je bent ingelogt als: {{ Auth::user()->name }}, <a href="{{ url('logout') }}"> uitloggen</a></div>
@endif
<table>
    @if (!is_null($projects))
        @foreach ($projects as $project)
            <tbody>
                <tr>
                    <td class="">
                        {{ $project->name }}
                        {{ $project->description }}
                        {{ $project->creator }}
                    </td>
                </tr>
            </tbody>
            <br>
            <a href="/projects/project/{{ $project->id }}"><button type="submit">Open Project</button></a>
        @endforeach
    @endif
</table>
<br>
<a href="/projects/createproject">Nieuw Project</a> <br>
<head>
</head>

</html>
