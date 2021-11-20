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
                    {{ $comment->text}}
                </p>
            @endforeach
        </div>
    @endforeach
@endsection