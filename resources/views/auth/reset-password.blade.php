@extends('layouts.account')

@section('title', "Reset Password")

@section('form')
    
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
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
            <button type="submit" class="btn btn-secondary">Reset Password</button>
        </div>  
    </form>

@endsection