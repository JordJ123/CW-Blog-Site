<!doctype html>
<html lang="en">

    <head>
        <title>Posts 'R' Us - @yield('title')</title>
    </head>
    
    <body>
        <div>
            <h1>@yield('title')</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <input type="submit" value="Logout">
            </form>
        </div>
        <div>
            @yield('content')    
        </div>
    </body>

</html>