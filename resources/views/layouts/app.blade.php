<!doctype html>
<html lang="en">

    <head>
        <title>Posts 'R' Us - @yield('title')</title>
    </head>
    
    <body>

        @if (session('message'))
            <div>
                <p><b>{{ session('message') }}</b></p>
            </div>
        @endif

        @if ($errors->any()) 
            <div style="color:red">
                Errors:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <h1>@yield('title')</h1>
        </div>
        <div>
            @yield('content')    
        </div>
    </body>

</html>