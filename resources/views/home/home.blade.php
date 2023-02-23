@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        @if ($dataDisplay == 'none')
            
        @endif

        @if ($dataDisplay == 'articles')
            <div class="row border">
              <h2> Artikelen </h2>
                <div class="col-2 border">
                    id
                </div>
                <div class="col-2 border">
                    titel
                </div>
                <div class="col-2 border">
                    bescrijving
                </div>
                <div class="col-2 border">
                    auteur
                </div>
                <div class="col-4 border">
                    acties
                </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">First</th>
                      <th scope="col">Last</th>
                      <th scope="col">Handle</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($articles as $article)
                    <tr>
                      <th scope="row">1</th>
                      <td> {{ $article->id }}</td>
                      <td> {{ $article->title }}</td>
                      <td> {{ $article->description }}</td>
                      <td> {{ $article->author }}</td>
                      
                    </tr>
    
   
                  
                    <div class="col-4">
                        <a href="/articles/article/{{ $article->id }}"><button class="btn btn-primary btn-sm">Open artikel</button></a>
                    </div>
                @endforeach
                  </tbody>
                </table>
                
                <div class="col-11"></div>
                <div class="col-1"><a href="/articles/createarticle"><button class="btn btn-secondary btn-md">Toevoegen</button></a></div>
            </div>
        @endif
          
        @if ($dataDisplay == 'projects')

            <div class="row border">
              <h2> Projecten </h2>
              <div class="col-2 border">
                  id
              </div>
              <div class="col-3 border">
                  naam
              </div>
              <div class="col-3 border">
                  bescrijving
              </div>
              <div class="col-4 border">
                  acties
              </div>

              @foreach ($projects as $project)
                  <div class="col-2">
                      {{ $project->id }}
                  </div>
                  <div class="col-3">
                      {{ $project->name }}
                  </div>
                  <div class="col-3">
                      {{ $project->description }}
                  </div>
                  <div class="col-4">
                      <a href="/projects/project/{{ $project->id }}"><button class="btn btn-primary btn-sm">Open project</button></a>
                  </div>
              @endforeach
              <div class="col-11"></div>
              <div class="col-1"><a href="/projects/createproject"><button class="btn btn-secondary btn-md">Toevoegen</button></a></div>
          </div>
        @endif

        @if ($dataDisplay == 'users')
        <div class="row border">
          <h2> Gebruikersbeheer </h2>
          <div class="col-2 border">
              id
          </div>
          <div class="col-3 border">
              gebruiker
          </div>
          <div class="col-3 border">
              email
          </div>
          <div class="col-4 border">
              acties
          </div>
          @foreach ($users as $user)
                  <div class="col-2">
                      {{ $user->id }}
                  </div>
                  <div class="col-3">
                      {{ $user->name }}
                  </div>
                  <div class="col-3">
                      {{ $user->email }}
                  </div>
                  <div class="col-4">
                    @if($user->isAdmin == 1 && $user->isOwner == 0 && $user->name !== Auth::user()->name)
                    <form method="POST" action="/users/removeadmin">
                        <input type="hidden" name="id" value={{$user->id}}>
                        <button class="btn btn-danger btn-sm" type="submit">Verwijder admin privileges</button>
                        @csrf
                    </form>
                    @endif
                    @if($user->isAdmin == 0 && $user->isOwner == 0)
                    <form method="POST" action="/users/makeadmin ">
                        <input type="hidden" name="id" value={{$user->id}}>
                        <button class="btn btn-danger btn-sm" type="submit">Geef admin privileges</button>
                        @csrf
                    </form>
                    @endif
                  </div>
              @endforeach
        @endif
        
    </div>

    @endsection

    @section('sidebar')
        <ul class="list-group" style="width: 15%">
            <a href="/home">
                <li class="list-group-item active">Menu</li>
            </a>
            <a href="/home/articles">
                <li class="list-group-item">Blog arikelen</li>
            </a>
            <a href="/home/projects">
                <li class="list-group-item">Projecten</li>
            </a>
            <a href="/home/manageusers">
              <li class="list-group-item">Beheer gebruikers</li>
          </a>
        </ul></a>
    @endsection
