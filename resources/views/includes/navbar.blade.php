<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-5">
  <div class="container">
      <a class="navbar-brand" href="/">
          {{ config('app.name', 'Laravel') }}
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->

        <ul class="navbar-nav mr-auto">
        <a class="nav-link" href="/">Home</a>
        </ul>
        <ul class="navbar-nav mr-auto">
        <a class="nav-link" href="{{ route('articles.index') }}">Laatste nieuws</a>
        </ul>
        <ul class="navbar-nav mr-auto">
        <a class="nav-link" href="{{ route('projects.index') }}">Projecten</a>
        </ul>
        <ul class="navbar-nav mr-auto position-relative">
        
            <a id="navbarDropdownProducts" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                Producten
            </a>
            <div  class="dropdown-menu dropdown-menu " aria-labelledby="navbarDropdownProducts">
                @foreach($productCategories as $category)
                  <a class="dropdown-item" href="{{ route('products.categories.index', $category) }}">{{$category->name}}</a>
                @endforeach
            </div>
        </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ms-auto">
            <p class="btn-holder"><a href="{{ route('products.cart') }}" class="btn btn btn-block text-center text-secondary" role="button"><i class="fa fa-shopping-cart"></i> </a> </p>

            @if(Auth::user())
            @if(Auth::user()->isAdmin)
            <ul class="navbar-nav mr-auto navbar-right">

            <a class="nav-link" href="{{ route('admin.index') }}">Admin</a>
            </ul>
            @endif
            @endif
              <!-- Authentication Links -->
              @guest
                  @if (Route::has('login'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                      </li>
                  @endif
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">Registreren</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }}
                      </a>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('orders.index') }}">Mijn bestellingen</a>
                            <a class="dropdown-item" href="{{ route('adresses.index') }}">Mijn adressen</a>
                            <form action="/logout" method="POST">
                                <a class="dropdown-item" href="#" onclick="this.parentNode.submit()">Uitloggen</a>
                                @csrf
                            </form>
                      </div>
                      
                  </li>
              @endguest
          </ul>
      </div>
  </div>
</nav>