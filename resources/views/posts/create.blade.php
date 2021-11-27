@extends('layouts.app')

@section('title', 'New Post')

@section('content')
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <input type="text" name="text" value="{{ old('text') }}"><br><br>
        <input type="submit" value="Send"><br><br>
    </form>
    <a href="{{ route('posts.index') }}">Cancel</a>
@endsection

