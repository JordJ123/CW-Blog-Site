@extends('layouts.email')

<div >
    <p>A comment has been posted on of your posts</p>
    <div class="p-3 mb-3 border border-dark">
        <p><b>{{ $post->user()->first()->name }}</b></p>
        <p>{{ $post->text }}</p>
        @if ($post->image()->first() != null)
            <p><img src="'images/' + {{ $post->image()->first()->path }}" 
                alt="{{ $post->image()->first()->text }}" style="height:128px"/></p>
        @endif
        <p>{{ $comment->user()->first()->name }}: {{ $comment->text }}</p>
    </div>
</div>    