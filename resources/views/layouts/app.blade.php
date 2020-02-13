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
            <nav class="navbar navbar-expand-md navbar-dark bg-primary">
                <div class="justify-content-end">
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
                        <a class="nav-item nav-link btn btn-lg text-white" href="{{ route('register') }}">Register</a>
                    @endguest
                    </div>
                </div>
            </nav>
        @show

        <div class="container mt-3">
            @if( session('success') )
                <div class="alert alert-success text-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @yield('contenu')
        </div>
    </body>
</html>
