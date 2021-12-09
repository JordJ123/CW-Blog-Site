@extends('layouts.app')

@section('content')

    <div class="position-absolute top-50 start-50 translate-middle">
        <h1 class="text-center">Home</h1>
        <a class="btn btn-primary m-1" href="{{ route('login') }}">Sign In</a>
        <a class="btn btn-secondary m-1" href="{{ route('register') }}">Register Account</a>
    </div>

@endsection