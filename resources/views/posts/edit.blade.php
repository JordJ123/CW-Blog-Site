@extends('layouts.app')

@section('content')

    @if ($post->image()->first() != null)
        @php
            $value = $post->image()->first()->text;
        @endphp
    @else
        @php
            $value = "";
        @endphp       
    @endif  

    <div>
        <h1 class="text-primary">Edit Post</h1>
        <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="deleteImage" :value="deleteImage">
            <div class="mb-3">
                <label for="text" class="form-label text-primary">Post Text</label>
                <input type="text" class="form-control" id="text" name="text" 
                    value="{{ $post->text }}" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label text-primary">Image File</label>
                <button type="button" v-if="hasImage" class="text-secondary btn btn-danger" 
                    @click="destroyImageFile()">Remove Image</button>
                <input v-if="!hasImage" type="file" class="form-control" id="file" name="file">
            </div>
            <div class="mb-3">
                <label for="imageText" class="form-label text-primary">
                    Image Alt Text (if post has image)</label>
                <input type="text" class="form-control" id="imageText" name="imageText" 
                    value="{{ $value }}" maxlength="255">
            </div>
            <div>
                <button type="submit" class="text-secondary btn btn-primary">Update</button>
                <a class="btn link-dark" href="{{ route('posts.index') }}">Cancel</a>
            </div> 
        </form>
    </div>

    <script>
        var app = new Vue ({
            el: "#content",
            data: {
                hasImage: "{{ ($post->image()->first() != null) }}",
                deleteImage: false,
            },
            methods: {
                destroyImageFile:function() {
                    this.hasImage = false;
                    this.deleteImage = true;
                }
            }
        });      
    </script>

@endsection

