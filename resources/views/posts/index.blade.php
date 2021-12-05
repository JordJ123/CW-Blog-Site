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
                    <form method="POST" action="{{ route('posts.destroy', 
                        ['id' => $post->id]) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete">
                    </form>
                @endif   
                @if ($alreadyLiked)
                        <form method="POST" action="{{ route('posts.updateLike', 
                            ['id' => $post->id, 'like' => 'false']) }}">
                            @csrf
                            @method('PATCH')
                            <input type="submit" value="Unlike">
                        </form>
                    @else
                        <form method="POST" action="{{ route('posts.updateLike', 
                            ['id' => $post->id, 'like' => 'true']) }}">
                        @csrf
                        @method('PATCH')
                        <input type="submit" value="Like">
                    </form>
                @endif
            </b><p>
            @if ($post->image()->first() != null)
                <p><img 
                    src="{{ 'images/'.$post->image()->first()->path }}" 
                    alt="{{ $post->image()->first()->text }}" 
                    style="height:128px"/></p>
            @endif
            <p> {{ $post->text }}</p>
            @foreach ($post->comments()->get() as $comment)
                @php
                    $post = $posts->reverse()->values()[$i];
                    $commentLiked = false;
                @endphp    
                @foreach ($comment->likes()->get() as $user)
                    @if ($user->id == auth()->user()->id)
                        @php
                            $commentLiked = true;
                            break;                            
                        @endphp    
                    @endif
                @endforeach
                <p>
                    {{ $comment->user()->first()->name }}
                    (Likes {{ $comment->likes()->count() }}): 
                    {{ $comment->text }}
                    @if ($comment->user()->first() == auth()->user())
                        <a href="{{ route('comments.edit', ['id' => $comment->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('comments.destroy', 
                            ['id' => $comment->id]) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete">
                        </form>
                    @endif 
                    @if ($commentLiked)
                        <form method="POST" action="{{ route('comments.updateLike', 
                            ['id' => $comment->id, 'like' => 'false']) }}">
                            @csrf
                            @method('PATCH')
                            <input type="submit" value="Unlike">
                        </form>
                    @else
                        <form method="POST" action="{{ route('comments.updateLike', 
                            ['id' => $comment->id, 'like' => 'true']) }}">
                            @csrf
                            @method('PATCH')
                            <input type="submit" value="Like">
                        </form>
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
        @if ($page != ceil($posts->count() / 5) && $posts->count() != 0)
            <a href="{{ route('posts.index', ['page' => $page + 1]) }}">Next</a>
        @endif
    </div>  

@endsection