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
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #734b75">
                <a class="navbar-brand">
                    INSA Centre-Val de Loire
                    <span class="border-left border-white m-1 p-2">
                        @auth
                            {{ Auth::user()->identite->prenom }} {{ Auth::user()->identite->nom }}
                        @endauth
                    </span>
                </a>

                {{-- Bouton pour collapse les elements (hamburger) --}}
                <button class="navbar-toggler border border-white" type="button" data-toggle="collapse" data-target="#contenuToggle" aria-controls="contenuToggle" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Tout ce qui est ici sera collapsed si besoin --}}
                <div class="collapse navbar-collapse flex-row  justify-content-end" id="contenuToggle">
                    {{-- Notre partie pour les actions de l'utilisateur --}}
                    <ul class="nav nav-pills nav-fill">

                        {{-- div actions specifiques --}}
                         @auth
                            {{-- 'Accueil' et 'Se deconnecter' --}}
                            <li class="nav-item">
                                @if(Auth::user()->estEnseignant())
                                    <a class="btn btn-lg text-white" href="{{ route('referents.index.index') }}">Accueil</a>
                                @elseif(Auth::user()->estScolariteINSA())
                                    <a class="btn btn-lg text-white" href="{{ route('scolarite.index') }}">Accueil</a>
                                @endif
                            </li>
                            <li class="nav-item">
                                <form class="form-inline my-2 my-lg-0" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn btn-lg nav-link text-white" type="submit">Se déconnecter</button>
                                </form>
                            </li>
                         @endauth

                        @guest
                                <li class="nav-item">
                                    <a class="nav-link btn btn-lg text-white " href="{{ route('login') }}">Login</a>
                                </li>
                        @endguest
                    </ul>
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
