<html>
    <head>
        <title>@yield('titre')</title>
        @yield('inclusionHead')
        <script src="https://kit.fontawesome.com/645d400b85.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}"/>
    </head>
    <body>
        @section('sidebar')
            {{--
            <nav class="navbar navbar-expand-md navbar-dark bg-primary">
                <div class="navbar-collapse justify-content-end">
                    <div class="navbar-nav">
                    @auth
                    <a class="nav-item nav-link btn btn-lg text-white" href="{{ url('/home') }}">Accueil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-lg nav-item nav-link text-white" type="submit">Se déconnecter</button>
                    </form>
                    @endauth

                    @guest
                        <a class="nav-item nav-link btn btn-lg text-white" href="{{ route('login') }}">Login</a>
                    @endguest
                    </div>
                </div>
            </nav>
            --}}
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">INSA</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dropdown
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        @show

        <div class="mx-5 mt-3">
            @if( session('error') )
                <div class="alert alert-danger text-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if( session('success') )
                <div class="alert alert-success text-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @yield('contenu')
        </div>

    {{-- Dependance JQuery, Popper.js et BootstrapJS --}}
    {{-- L'ordre d'inclusion est tres important : ne pas le modifier ! --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
