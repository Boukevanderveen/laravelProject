@extends('layouts.app')
@section('content')
<h1>{{$project->name}}</h1>
{{$project->description}}
<br><br>
Gemaakt op: {{$project->created_at->format('d-m-Y')}}
<br>
<br>
<a href="{{ route('projects.index') }}"><button type="button" class="btn mb-3">Ga terug</button></a>

@endsection 