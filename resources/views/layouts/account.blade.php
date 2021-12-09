@extends('layouts.app')

@section('content')
    
    <div class="w-50 position-absolute top-50 start-50 translate-middle bg-primary p-3">
        <h1 class="text-secondary text-center">@yield('title')</h1>
        @yield('form')
  </div>

@endsection