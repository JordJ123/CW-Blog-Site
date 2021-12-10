@extends('layouts.app')

@section('title', 'New Post')

@section('content')
    <h1 class="text-primary">New Post</h1>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="text" class="form-label text-primary">Post Text</label>
            <input type="text" class="form-control" id="text" name="text" 
                value="{{ old('text') }}">
        </div>
        <div class="mb-3">
            <label for="imageText" class="form-label text-primary">Image Alt Text</label>
            <input type="text" class="form-control" id="imageText" name="imageText" 
                value="{{ old('imageText') }}">
        </div>
        <div class="mb-3">
            <label for="file" class="form-label text-primary">Image File</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>
        <div>
            <button type="submit" class="text-secondary btn btn-primary">Update</button>
            <a class="btn link-dark" href="{{ route('posts.index') }}">Cancel</a>
        </div>
    </form>
    
@endsection

