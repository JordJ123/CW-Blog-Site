<!doctype html>
<html lang="en">

    <head>
        <title>Posts 'R' Us - @yield('title')</title>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
        <div id="content">
            @yield('content')    
        </div>
    </body>

</html>