@extends('layouts.app')

@section('content')
    
  <div class="w-50 position-absolute top-50 start-50 translate-middle border border-dark bg-primary 
      p-3">
      <a href="{{ route('home') }}">
        <h1 class="text-secondary text-center"><b>POSTS 'R' US</b></h1></a>
      <h1 class="text-secondary text-center">@yield('title')</h1>
      @yield('form')
  </div>

@endsection