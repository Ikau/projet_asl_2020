<html>
    <head>
        <title>@yield('titre')</title>
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}"/>
    </head>
    <body>
        @section('sidebar')
            <nav class="navbar navbar-dark bg-primary">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a class="text-white" href="{{ url('/home') }}">Home</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        @else
                            <a class="text-white" href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a class="text-white" href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
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
