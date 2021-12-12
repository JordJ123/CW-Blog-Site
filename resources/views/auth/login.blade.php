@extends('layouts.account')

@section('title', "Login")

@section('form')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label text-secondary">Email address</label>
            <input type="email" class="form-control" id="email" name="email"
                maxlength="255" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-secondary">Password</label>
            <input type="password" class="form-control" id="password" name="password" 
                maxlength="15" required>
        </div>
        <div class="mb-3 form-check">
            <label class="form-check-label text-secondary" for="remember">Remember Me</label>
            <input type="checkbox" class="form-check-input" id="remember" 
                name="remember">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary">Login</button>
            <a class="btn btn-secondary m-1" href="{{ route('password.request') }}">
                Forgot Password?</a>
        </div>
        <div class="text-center">
            <a class="btn link-dark" href="{{ route('register') }}">
                Don't Already Have an Account?</a>
        </div> 
    </form>
@endsection