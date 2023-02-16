<!DOCTYPE html>
<html>
@include('auth.authcheck')
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
        @endforeach
    @endif
</table>

<head>
    @foreach ($projects as $project)
    @if (Auth::user()->can('create', $project))
    <a href="/createproject">Nieuw Project</a> <br>
    @endif
    @endforeach
</head>

</html>
