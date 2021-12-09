<!doctype html>
<html lang="en">

    <head>

        <title>VideoSync</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @livewireStyles

        <script src="{{ asset('js/app.js') }}"></script>
        @livewireScripts

    </head>
    
    <body>

        <div id="content" class="containter m-3">
            
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

            @yield('content')  

        </div>

    </body>

</html>