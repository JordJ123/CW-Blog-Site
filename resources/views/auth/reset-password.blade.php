@extends('layouts.app')

@section('title', "Reset Password")

@section('content')
    
  <div class="w-50 position-absolute top-50 start-50 translate-middle border border-dark bg-primary 
      p-3">
      <h1 class="text-secondary text-center">@yield('title')</h1>
      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
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
            <button type="submit" class="text-primary btn btn-secondary">Reset Password</button>
        </div>  
    </form>
  </div>
    
@endsection