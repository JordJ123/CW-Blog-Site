@extends('layouts.app')

@section('title', 'New Post')

@section('content')
    <h1 class="text-primary">@yield('title')</h1>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="text" class="form-label text-primary">Post Text</label>
            <input type="text" class="form-control" id="text" name="text" 
                value="{{ old('text') }}" maxlength="255" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label text-primary">Image File</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>
        <div class="mb-3">
            <label for="imageText" class="form-label text-primary">
                Image Alternate Text (displays if the image can not load)</label>
            <input type="text" class="form-control" id="imageText" name="imageText" 
                value="{{ old('imageText') }}" maxlength="255">
        </div>
        <div>
            <button type="submit" class="text-secondary btn btn-primary me-2">Create</button>
            <a class="link-primary" href="{{ route('posts.index') }}">Cancel</a>
        </div>
    </form>
    
@endsection

