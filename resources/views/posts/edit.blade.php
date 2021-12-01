@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}">
        @csrf
        @method('PUT')
        <input type="text" name="text" value="{{ $post->text }}"><br><br>
        <input type="submit" value="Update"><br><br>
    </form>
    <a href="{{ route('posts.index') }}">Cancel</a>
@endsection

