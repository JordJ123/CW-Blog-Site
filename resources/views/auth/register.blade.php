@extends('layouts.account')

@section('title', "Register")

@section('form')
<div class="section">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label text-secondary">Username</label>
                <input type="text" class="form-control" id="name" name="name" 
                    value="{{ old ('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label text-secondary">Email address</label>
                <input type="email" class="form-control" id="email" name="email" 
                    value="{{ old ('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-secondary">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label text-secondary">
                    Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" 
                    name="password_confirmation" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-secondary">Register</button>
            </div>    
            <div class="text-center">
                <a class="btn link-dark " href="{{ route('login') }}">
                    Already Have an Account?</a>
            </div>     
        </form>
    </div>
@endsection