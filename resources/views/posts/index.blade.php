@extends('layouts.app')

@section('title', 'Feed')

@section('content')

    <a href="{{ route('posts.create') }}">New Post</a>

    @foreach ($posts->reverse() as $post)
        <div>
            <p><b>
                {{ $post->user()->first()->name }}
                (Likes {{ $post->likes()->count() }})
            </b><p>
            <p>{{ $post->text }}</p>
            @foreach ($post->comments()->get() as $comment)
                <p>
                    {{ $comment->user()->first()->name }}
                    (Likes {{ $comment->likes()->count() }}): 
                    {{ $comment->text }}
                </p>                    
            @endforeach
            <form method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    Comment: <input type="type" name="text"
                        value="{{ old('name') }}">
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="submit" value="Send">
            </form>
        </div>
    @endforeach

    <div>
        <br>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="submit" value="Logout">
        </form>
    </div>

@endsection