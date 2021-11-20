@extends('layouts.app')

@section('title', 'Feed')

@section('content')
    @foreach ($posts as $post)
        <div>
            <p><b>{{ $post->user()->first()->name }}</b><p>
            <p>{{ $post->text }}</p>
            @foreach ($post->comments()->get() as $comment)
                <p>{{ $comment->user()->first()->name }}: {{ $comment->text}}</p>
            @endforeach
        </div>
    @endforeach
@endsection