@extends('layouts.app')

@section('content')
    
    <div>
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email 
                    aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">
                    We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" 
                    name="remember">
                <label class="form-check-label" for="remember">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>   
        </form>
        <p><a href="{{ route('password.request') }}">Forgot Password?</a></p>
        <p><a href="{{ route('register') }}">Don't Already Have an Account?</a></p>
    </form>
  </div>

@endsection