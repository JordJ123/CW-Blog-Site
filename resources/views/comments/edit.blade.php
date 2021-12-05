@extends('layouts.app')

@section('title', 'Edit Comment')

@section('content')
    <form method="POST" action="{{ route('comments.update', ['id' => $comment->id]) }}">
        @csrf
        @method('PUT')
        <input type="text" name="text" 
            value="{{ $comment->text }}" required><br><br>
        <input type="submit" value="Update" required><br><br>
    </form><br>
    <a href="{{ route('posts.index') }}">Cancel</a>
@endsection

