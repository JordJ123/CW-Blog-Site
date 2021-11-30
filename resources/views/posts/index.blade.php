@extends('layouts.app')

@section('title', 'Feed')

@section('content')

    <a href="{{ route('posts.create') }}">New Post</a>

    @php
        $end = min($page * 5, $posts->count());
    @endphp
    @for ($i = (($page - 1) * 5); $i < $end; $i++)
        <div>
            @php
                $post = $posts->reverse()->values()[$i];
                $alreadyLiked = false;
            @endphp
            @foreach($post->likes() as $user)
                @if ($user == auth()->user())
                    $alreadyLiked = true;
                    break;
                @endif
            @endforeach
            <p><b>
                {{ $post->user()->first()->name }}
                (Likes {{ $post->likes()->count() }})
                @if ($post->user()->first() == auth()->user())
                    <a href="{{ route('posts.edit', ['id' => $post->id]) }}">Edit</a>
                @endif   
                @if ($alreadyLiked) {
                    <a href="">Unlike</a>
                @else
                    <a href="">Like</a>
                @endif 
            </b><p>
            <p> {{ $post->text }}</p>
            @foreach ($post->comments()->get() as $comment)
                @php
                    $post = $posts->reverse()->values()[$i];
                    $commentLiked = false;
                @endphp
                @foreach($comment->likes() as $user)
                    @if ($user == auth()->user())
                        $commentLiked = true;
                        break;
                    @endif
                @endforeach
                <p>
                    {{ $comment->user()->first()->name }}
                    (Likes {{ $comment->likes()->count() }}): 
                    {{ $comment->text }}
                    @if ($comment->user()->first() == auth()->user())
                        <a href="">Edit</a>
                    @endif 
                    @if ($alreadyLiked) {
                        <a href="">Unlike</a>
                    @else
                        <a href="">Like</a>
                    @endif
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
    @endfor

    <div>
        <br>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="submit" value="Logout">
        </form>
    </div>

    <div style="text-align:center">
        @php
            $start = max (1, $page - 4);
            $end = min (ceil($posts->count() / 5), $page + 4)
        @endphp
        @if ($page != 1)
            <a href="{{ route('posts.index', ['page' => $page - 1]) }}">Previous</a>
        @endif
        @for ($i = $start; $i <= $end; $i++)
            @if ($page != $i)
                <a href="{{ route('posts.index', ['page' => $i]) }}">{{ $i }}</a>
            @else
                <b> {{ $i }} </b>
            @endif    
        @endfor
        @if ($page != ceil($posts->count() / 5))
            <a href="{{ route('posts.index', ['page' => $page + 1]) }}">Next</a>
        @endif
    </div>  

@endsection