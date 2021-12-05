@extends('layouts.app')

@section('title', 'New Post')

@section('content')
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        Post Text <input type="text" name="text" value="{{ old('text') }}"><br><br>
        Image Alt Text <input type="text" name="imageText" 
            value="{{ old('imageText') }}"><br><br>
        Image File <input type="file" name="file"><br><br> 
        <input type="submit" value="Post"><br><br>
    </form>
    <a href="{{ route('posts.index') }}">Cancel</a>
@endsection

