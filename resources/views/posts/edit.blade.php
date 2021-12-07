@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        Post Text <input type="text" name="text" 
            value="{{ $post->text }}" required><br><br>
        @if ($post->image()->first() != null)
            @php
                $value = $post->image()->first()->text;
            @endphp
        @else
            @php
                $value = "";
            @endphp       
        @endif     
        Image Alt Text <input type="text" name="imageText" value="{{ $value }}"><br><br>
        Image File <input type="file" name="file"><br><br>
        <input type="submit" value="Update"><br><br>
    </form>
    @if ($post->image()->first() != null)
        <form method="POST" action="{{ route('posts.destroyImageFile', 
            ['id' => $post->id]) }}">
            @csrf
            @method('DELETE')
            <input type="submit" value="Remove Image">
        </form><br>
    @endif
    <a href="{{ route('posts.index') }}">Cancel</a>
@endsection

