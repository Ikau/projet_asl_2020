<html>
    <head>
        <title>@yield('titre')</title>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}"/>
    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
        @show

        <div class="container">
            @yield('contenu')
        </div>
    </body>
</html>
