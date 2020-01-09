<html>
    <head>
        <title>@yield('titre')</title>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}"/>
    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        @show

        <div class="container">
            @yield('contenu')
        </div>
    </body>
</html>
