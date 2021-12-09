@extends('layouts.account')

@section('title', "Forgot Password")

@section('form')
    
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label text-secondary">Email address</label>
            <input type="email" class="form-control" id="email" name="email" 
                value="{{ old ('email') }}" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-secondary">Email Password Link</button>
        </div>
        <div class="text-center">
            <a class="btn link-dark " href="{{ route('login') }}">
                Remembered your Password?</a>
        </div> 
    </form>

@endsection