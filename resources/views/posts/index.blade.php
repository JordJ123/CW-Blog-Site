@extends('layouts.app')

@section('title', 'Feed')

@section('content')
    @foreach ($posts as $post)
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
                    <p>Text: <input type="type" name="text"
                        value="{{ old('name') }}"></p>
                    <p>
                        User ID: <input type="text" name="user_id"
                        value="{{ old('user_id') }}">
                        <input type="submit" value="Send">
                    </p>
                    <input type="hidden" name="post_id"value="{{ $post->id }}">
            </form>
        </div>
    @endforeach
@endsection