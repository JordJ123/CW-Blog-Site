<!doctype html>
<html lang="en">

    <head>
        <title>Posts 'R' Us - @yield('title')</title>
    </head>
    
    <body>
        
        <div>
            <h1>@yield('title')</h1>
        </div>

        @if (session('message'))
            <div>
                <p><b>Developer Message: {{ session('message') }}<b><p>
            </div>
        @endif  

        @if ($errors->any())
            <div><b>
                Developer Errors:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach    
                </ul>
            </b></div>
        @endif     
                
        <div>
            @yield('content')    
        </div>

    </body>

</html>