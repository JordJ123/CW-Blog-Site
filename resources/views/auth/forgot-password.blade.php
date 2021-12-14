@extends('layouts.account')

@section('title', "Forgot Password")

@section('form')
    
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label text-secondary">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" 
                value="{{ old ('email') }}" maxlength="255" required>
        </div>
        <div class="text-center">
            <button type="submit" class="text-primary btn btn-secondary mb-2">
                Email Password Link</button>
        </div>
        <div class="text-center">
            <a class="link-secondary " href="{{ route('login') }}">
                Remembered your password?</a>
        </div> 
    </form>

@endsection