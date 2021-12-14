@extends('layouts.account')

@section('title', "Register")

@section('form')

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label text-secondary">Username</label>
            <input type="text" class="form-control" id="name" name="name" 
                value="{{ old ('name') }}" maxlength="15" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-secondary">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" 
                value="{{ old ('email') }}" maxlength="255" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-secondary">Password</label>
            <input type="password" class="form-control" id="password" name="password" 
                maxlength="15" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label text-secondary">
                Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" 
                name="password_confirmation" maxlength="15" required>
        </div>
        <div class="text-center">
            <button type="submit" class="mb-2 text-primary btn btn-secondary">Register</button>
        </div>    
        <div class="text-center">
            <a class="link-secondary" href="{{ route('login') }}">
                Already have an account?</a>
        </div>     
    </form>
    
@endsection